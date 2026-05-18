<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispositivos_registrados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios_sistema')->nullOnDelete()->cascadeOnUpdate();
            $table->string('nombre', 150);
            $table->string('fingerprint_hash')->nullable()->unique();
            $table->string('registro_token_hash')->nullable()->unique();
            $table->string('ip_registro', 100)->nullable();
            $table->text('user_agent_registro')->nullable();
            $table->timestamp('registrado_at')->nullable();
            $table->timestamp('ultimo_acceso_at')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispositivos_registrados');
    }
};
