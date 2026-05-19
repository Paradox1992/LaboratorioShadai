<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tokens_acceso_dispositivo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dispositivo_registrado_id')
                ->constrained('dispositivos_registrados')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('jwt_id')->unique();
            $table->string('token_hash')->unique();
            $table->string('user_agent_hash')->nullable();
            $table->string('ip_address', 100)->nullable();
            $table->timestamp('issued_at');
            $table->timestamp('expires_at')->index();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('revoked_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens_acceso_dispositivo');
    }
};
