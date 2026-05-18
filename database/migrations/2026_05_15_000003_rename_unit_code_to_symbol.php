<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('unidades_medida', 'codigo') && ! Schema::hasColumn('unidades_medida', 'simbolo')) {
            Schema::table('unidades_medida', function ($table) {
                $table->renameColumn('codigo', 'simbolo');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('unidades_medida', 'simbolo') && ! Schema::hasColumn('unidades_medida', 'codigo')) {
            Schema::table('unidades_medida', function ($table) {
                $table->renameColumn('simbolo', 'codigo');
            });
        }
    }
};
