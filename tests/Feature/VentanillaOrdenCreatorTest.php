<?php

namespace Tests\Feature;

use App\Filament\Resources\VentanillaOrdens\Support\VentanillaOrdenCreator;
use App\Models\Examen;
use App\Models\ExamenGrupo;
use App\Models\ExamenVariante;
use App\Models\NivelReferencia;
use App\Models\Paciente;
use App\Models\TipoMuestra;
use App\Models\UnidadMedida;
use App\Models\User;
use App\Models\ValorReferencia;
use App\UserRole;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class VentanillaOrdenCreatorTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_it_creates_a_pos_order_with_selected_variant_reference(): void
    {
        $user = User::create([
            'nombre' => 'Recepcion',
            'usuario' => 'recepcion',
            'correo' => 'recepcion@example.com',
            'password' => 'password',
            'rol' => UserRole::User->value,
            'estado' => true,
        ]);

        $this->actingAs($user);

        $paciente = Paciente::create([
            'docid' => '0801199012345',
            'nombres' => 'Ana',
            'apellidos' => 'Lopez',
            'sexo' => 'FEMENINO',
            'estado' => true,
        ]);

        $grupo = ExamenGrupo::create(['nombre' => 'Hematologia']);
        $tipoMuestra = TipoMuestra::create(['nombre' => 'Sangre']);
        $unidad = UnidadMedida::create([
            'simbolo' => 'g/dL',
            'nombre' => 'Gramos por decilitro',
        ]);
        $nivel = NivelReferencia::create(['nombre' => 'Adulto']);

        $examen = Examen::create([
            'grupo_id' => $grupo->id,
            'tipo_muestra_id' => $tipoMuestra->id,
            'nombre' => 'Hemograma',
            'requiere_ayuno' => false,
            'requiere_muestra' => true,
            'tiempo_entrega_horas' => 24,
            'estado' => true,
        ]);

        $variante = ExamenVariante::create([
            'examen_id' => $examen->id,
            'unidad_medida_id' => $unidad->id,
            'nombre' => 'Hemoglobina',
            'tipo_resultado' => 'NUMERICO',
            'estado' => true,
        ]);

        $referencia = ValorReferencia::create([
            'variante_id' => $variante->id,
            'nivel_id' => $nivel->id,
            'sexo' => 'FEMENINO',
            'operador' => 'RANGO',
            'valor_min' => 12,
            'valor_max' => 16,
            'unidad' => 'g/dL',
            'estado' => true,
        ]);

        $ventanillaOrden = app(VentanillaOrdenCreator::class)->create([
            'paciente_id' => $paciente->id,
            'paciente_edad' => 35,
            'paciente_telefono' => '99998888',
            'observacion' => 'Paciente en ayunas',
            'selecciones' => [
                [
                    'valor_referencia_id' => $referencia->id,
                    'resultado' => '13.5',
                ],
            ],
        ]);

        $ordenLaboratorio = $ventanillaOrden->ordenLaboratorio;
        $ordenExamen = $ordenLaboratorio->examenesOrdenados->first();
        $resultado = $ordenExamen->resultados->first();
        $paciente->refresh();

        $this->assertSame($paciente->id, $ventanillaOrden->paciente_id);
        $this->assertSame('99998888', $paciente->telefono);
        $this->assertSame(today()->subYears(35)->toDateString(), $paciente->fecha_nacimiento->toDateString());
        $this->assertSame($user->id, $ventanillaOrden->usuario_id);
        $this->assertFalse($ventanillaOrden->impresa);
        $this->assertSame('ABIERTA', $ventanillaOrden->estado);
        $this->assertSame($examen->id, $ordenExamen->examen_id);
        $this->assertSame($variante->id, $resultado->variante_id);
        $this->assertSame($referencia->id, $resultado->valor_referencia_id);
        $this->assertSame('13.5000', $resultado->resultado_numero);
        $this->assertSame('Adulto', $resultado->ref_nivel_nombre);
        $this->assertSame('g/dL', $resultado->unidad);
    }

    public function test_it_rejects_multiple_references_for_the_same_variant(): void
    {
        $user = User::create([
            'nombre' => 'Recepcion',
            'usuario' => 'recepcion-duplicado',
            'correo' => 'recepcion-duplicado@example.com',
            'password' => 'password',
            'rol' => UserRole::User->value,
            'estado' => true,
        ]);

        $this->actingAs($user);

        $paciente = Paciente::create([
            'docid' => '0801199012346',
            'nombres' => 'Carlos',
            'apellidos' => 'Lopez',
            'sexo' => 'MASCULINO',
            'estado' => true,
        ]);

        $grupo = ExamenGrupo::create(['nombre' => 'Quimica']);
        $tipoMuestra = TipoMuestra::create(['nombre' => 'Sangre']);
        $unidad = UnidadMedida::create([
            'simbolo' => 'mg/dL',
            'nombre' => 'Miligramos por decilitro',
        ]);
        $nivel = NivelReferencia::create(['nombre' => 'Adulto']);

        $examen = Examen::create([
            'grupo_id' => $grupo->id,
            'tipo_muestra_id' => $tipoMuestra->id,
            'nombre' => 'Colesterol',
            'requiere_ayuno' => false,
            'requiere_muestra' => true,
            'tiempo_entrega_horas' => 24,
            'estado' => true,
        ]);

        $variante = ExamenVariante::create([
            'examen_id' => $examen->id,
            'unidad_medida_id' => $unidad->id,
            'nombre' => 'HDL',
            'tipo_resultado' => 'NUMERICO',
            'estado' => true,
        ]);

        $referenciaMasculina = ValorReferencia::create([
            'variante_id' => $variante->id,
            'nivel_id' => $nivel->id,
            'sexo' => 'MASCULINO',
            'operador' => 'MAYOR_IGUAL',
            'valor_min' => 40,
            'unidad' => 'mg/dL',
            'estado' => true,
        ]);

        $referenciaFemenina = ValorReferencia::create([
            'variante_id' => $variante->id,
            'nivel_id' => $nivel->id,
            'sexo' => 'FEMENINO',
            'operador' => 'MAYOR_IGUAL',
            'valor_min' => 50,
            'unidad' => 'mg/dL',
            'estado' => true,
        ]);

        $this->expectException(ValidationException::class);

        app(VentanillaOrdenCreator::class)->create([
            'paciente_id' => $paciente->id,
            'selecciones' => [
                [
                    'valor_referencia_id' => $referenciaMasculina->id,
                    'resultado' => '55',
                ],
                [
                    'valor_referencia_id' => $referenciaFemenina->id,
                    'resultado' => '55',
                ],
            ],
        ]);
    }
}
