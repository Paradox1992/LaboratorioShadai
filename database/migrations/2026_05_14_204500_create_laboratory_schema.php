<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empresa_configuracion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_comercial', 150);
            $table->string('razon_social', 200)->nullable();
            $table->string('rtn', 50)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('correo', 150)->nullable();
            $table->text('direccion')->nullable();
            $table->string('logo_url')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('examen_grupos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('descripcion')->nullable();
            $table->integer('orden')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tipos_muestra', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('descripcion')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('unidades_medida', function (Blueprint $table) {
            $table->id();
            $table->string('simbolo', 50)->unique();
            $table->string('nombre', 100);
            $table->string('descripcion')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('niveles_referencia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('descripcion')->nullable();
            $table->integer('edad_min_dias')->nullable();
            $table->integer('edad_max_dias')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['edad_min_dias', 'edad_max_dias']);
        });

        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_documento', 30)->nullable();
            $table->string('docid', 50)->nullable()->index();
            $table->string('nombres', 150);
            $table->string('apellidos', 150);
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('sexo', ['MASCULINO', 'FEMENINO'])->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('correo', 150)->nullable();
            $table->text('direccion')->nullable();
            $table->string('contacto_emergencia_nombre', 150)->nullable();
            $table->string('contacto_emergencia_telefono', 50)->nullable();
            $table->text('alergias')->nullable();
            $table->text('enfermedades_base')->nullable();
            $table->text('observacion')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['nombres', 'apellidos']);
        });

        Schema::create('examenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained('examen_grupos')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('tipo_muestra_id')->nullable()->constrained('tipos_muestra')->nullOnDelete()->cascadeOnUpdate();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->boolean('requiere_ayuno')->default(false);
            $table->boolean('requiere_muestra')->default(true);
            $table->integer('tiempo_entrega_horas')->nullable();
            $table->integer('orden')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->index('nombre');
        });

        Schema::create('examen_variantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examen_id')->constrained('examenes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('unidad_medida_id')->nullable()->constrained('unidades_medida')->nullOnDelete()->cascadeOnUpdate();
            $table->string('nombre', 150);
            $table->string('descripcion')->nullable();
            $table->enum('tipo_resultado', ['NUMERICO', 'TEXTO', 'SELECT', 'POSITIVO_NEGATIVO', 'MULTIPLE', 'OBSERVACION'])->default('NUMERICO');
            $table->string('unidad_manual', 50)->nullable();
            $table->boolean('permite_decimales')->default(true);
            $table->integer('decimales')->default(2);
            $table->boolean('obligatorio')->default(true);
            $table->integer('orden')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->index('nombre');
        });

        Schema::create('valores_referencia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variante_id')->constrained('examen_variantes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('nivel_id')->nullable()->constrained('niveles_referencia')->nullOnDelete()->cascadeOnUpdate();
            $table->enum('sexo', ['MASCULINO', 'FEMENINO', 'AMBOS'])->default('AMBOS');
            $table->enum('operador', ['RANGO', 'MENOR_QUE', 'MENOR_IGUAL', 'MAYOR_QUE', 'MAYOR_IGUAL', 'IGUAL', 'TEXTO', 'SIN_REFERENCIA'])->default('RANGO');
            $table->decimal('valor_min', 14, 4)->nullable();
            $table->decimal('valor_max', 14, 4)->nullable();
            $table->string('valor_texto')->nullable();
            $table->string('unidad', 50)->nullable();
            $table->string('interpretacion_normal')->nullable();
            $table->string('observacion')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->index('sexo');
        });

        Schema::create('variante_opciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variante_id')->constrained('examen_variantes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('valor', 150);
            $table->string('descripcion')->nullable();
            $table->boolean('es_normal')->nullable();
            $table->integer('orden')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ventanilla_ordenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios_sistema')->nullOnDelete()->cascadeOnUpdate();
            $table->dateTime('fecha_recepcion');
            $table->enum('estado', ['ABIERTA', 'GENERADA', 'IMPRESA', 'ANULADA'])->default('ABIERTA');
            $table->enum('prioridad', ['NORMAL', 'URGENTE'])->default('NORMAL');
            $table->text('observacion')->nullable();
            $table->boolean('impresa')->default(false);
            $table->dateTime('fecha_impresion')->nullable();
            $table->integer('cantidad_impresiones')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index('fecha_recepcion');
        });

        Schema::create('ordenes_laboratorio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ventanilla_orden_id')->nullable()->constrained('ventanilla_ordenes')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('paciente_id')->constrained('pacientes')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios_sistema')->nullOnDelete()->cascadeOnUpdate();
            $table->dateTime('fecha_orden');
            $table->dateTime('fecha_toma_muestra')->nullable();
            $table->dateTime('fecha_entrega_estimada')->nullable();
            $table->dateTime('fecha_finalizacion')->nullable();
            $table->enum('estado', ['PENDIENTE', 'TOMA_MUESTRA', 'EN_PROCESO', 'FINALIZADA', 'ENTREGADA', 'ANULADA'])->default('PENDIENTE');
            $table->enum('prioridad', ['NORMAL', 'URGENTE'])->default('NORMAL');
            $table->text('diagnostico_presuntivo')->nullable();
            $table->string('medico_solicitante', 150)->nullable();
            $table->text('observacion')->nullable();
            $table->boolean('resultado_impreso')->default(false);
            $table->dateTime('fecha_resultado_impreso')->nullable();
            $table->integer('cantidad_impresiones_resultado')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index('fecha_orden');
        });

        Schema::create('orden_examenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('ordenes_laboratorio')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('examen_id')->constrained('examenes')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('nombre_examen_snapshot', 150)->nullable();
            $table->string('tipo_muestra_snapshot', 100)->nullable();
            $table->boolean('requiere_ayuno_snapshot')->default(false);
            $table->integer('tiempo_entrega_horas_snapshot')->nullable();
            $table->enum('estado', ['PENDIENTE', 'MUESTRA_TOMADA', 'EN_PROCESO', 'FINALIZADO', 'ANULADO'])->default('PENDIENTE');
            $table->text('observacion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['orden_id', 'examen_id']);
        });

        Schema::create('resultados_examen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_examen_id')->constrained('orden_examenes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('variante_id')->constrained('examen_variantes')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('valor_referencia_id')->nullable()->constrained('valores_referencia')->nullOnDelete()->cascadeOnUpdate();
            $table->decimal('resultado_numero', 14, 4)->nullable();
            $table->string('resultado_texto', 500)->nullable();
            $table->string('unidad', 50)->nullable();
            $table->string('variante_nombre_snapshot', 150)->nullable();
            $table->string('ref_nivel_nombre', 100)->nullable();
            $table->enum('ref_sexo', ['MASCULINO', 'FEMENINO', 'AMBOS'])->nullable();
            $table->string('ref_operador', 50)->nullable();
            $table->decimal('ref_valor_min', 14, 4)->nullable();
            $table->decimal('ref_valor_max', 14, 4)->nullable();
            $table->string('ref_valor_texto')->nullable();
            $table->string('ref_unidad', 50)->nullable();
            $table->enum('estado_resultado', ['BAJO', 'NORMAL', 'ALTO', 'ANORMAL', 'POSITIVO', 'NEGATIVO', 'SIN_CLASIFICAR'])->default('SIN_CLASIFICAR');
            $table->foreignId('validado_por')->nullable()->constrained('usuarios_sistema')->nullOnDelete()->cascadeOnUpdate();
            $table->dateTime('fecha_validacion')->nullable();
            $table->text('observacion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['orden_examen_id', 'variante_id']);
        });

        Schema::create('auditoria_eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios_sistema')->nullOnDelete()->cascadeOnUpdate();
            $table->string('tabla', 100);
            $table->unsignedBigInteger('registro_id')->nullable();
            $table->enum('accion', ['CREAR', 'ACTUALIZAR', 'ELIMINAR', 'ANULAR', 'VALIDAR', 'IMPRIMIR', 'ENTREGAR']);
            $table->text('descripcion')->nullable();
            $table->json('valor_anterior')->nullable();
            $table->json('valor_nuevo')->nullable();
            $table->string('ip', 100)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->index(['tabla', 'registro_id']);
            $table->index('accion');
        });
    }

    public function down(): void
    {
        foreach ([
            'auditoria_eventos',
            'resultados_examen',
            'orden_examenes',
            'ordenes_laboratorio',
            'ventanilla_ordenes',
            'variante_opciones',
            'valores_referencia',
            'examen_variantes',
            'examenes',
            'pacientes',
            'niveles_referencia',
            'unidades_medida',
            'tipos_muestra',
            'examen_grupos',
            'empresa_configuracion',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
