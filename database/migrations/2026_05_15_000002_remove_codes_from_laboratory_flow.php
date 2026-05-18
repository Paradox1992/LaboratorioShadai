<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->dropColumnIfExists('examenes', 'codigo');
        $this->dropColumnIfExists('examen_variantes', 'codigo');
        $this->dropColumnIfExists('ventanilla_ordenes', 'codigo');
        $this->dropColumnIfExists('ordenes_laboratorio', 'codigo');
        $this->dropColumnIfExists('orden_examenes', 'codigo_examen_snapshot');
        $this->dropColumnIfExists('resultados_examen', 'variante_codigo_snapshot');
    }

    public function down(): void
    {
        $this->addStringIfMissing('examenes', 'codigo');
        $this->addStringIfMissing('examen_variantes', 'codigo');
        $this->addStringIfMissing('ventanilla_ordenes', 'codigo');
        $this->addStringIfMissing('ordenes_laboratorio', 'codigo');
        $this->addStringIfMissing('orden_examenes', 'codigo_examen_snapshot');
        $this->addStringIfMissing('resultados_examen', 'variante_codigo_snapshot');
    }

    private function dropColumnIfExists(string $tableName, string $columnName): void
    {
        if (! Schema::hasColumn($tableName, $columnName)) {
            return;
        }

        $this->dropUniqueIndexIfExists($tableName, $columnName);

        Schema::table($tableName, function (Blueprint $table) use ($columnName) {
            $table->dropColumn($columnName);
        });
    }

    private function dropUniqueIndexIfExists(string $tableName, string $columnName): void
    {
        try {
            Schema::table($tableName, function (Blueprint $table) use ($columnName) {
                $table->dropUnique([$columnName]);
            });
        } catch (Throwable) {
            //
        }
    }

    private function addStringIfMissing(string $tableName, string $columnName): void
    {
        if (Schema::hasColumn($tableName, $columnName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($columnName) {
            $table->string($columnName, 50)->nullable();
        });
    }
};
