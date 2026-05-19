<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('usuarios_sistema')
            ->where('rol', 'ADMIN')
            ->update(['rol' => 'SOPORTE']);

        DB::table('usuarios_sistema')
            ->where('rol', 'USUARIO')
            ->update(['rol' => 'USER']);
    }

    public function down(): void
    {
        DB::table('usuarios_sistema')
            ->where('rol', 'SOPORTE')
            ->update(['rol' => 'ADMIN']);

        DB::table('usuarios_sistema')
            ->where('rol', 'USER')
            ->update(['rol' => 'USUARIO']);
    }
};
