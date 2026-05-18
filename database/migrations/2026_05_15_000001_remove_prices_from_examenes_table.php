<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('examenes', 'precio_referencial')) {
            return;
        }

        Schema::table('examenes', function (Blueprint $table) {
            $table->dropColumn('precio_referencial');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('examenes', 'precio_referencial')) {
            return;
        }

        Schema::table('examenes', function (Blueprint $table) {
            $table->decimal('precio_referencial', 14, 4)->default(0)->after('requiere_muestra');
        });
    }
};
