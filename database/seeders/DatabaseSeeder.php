<?php

namespace Database\Seeders;

use App\Models\EmpresaConfiguracion;
use App\Models\ExamenGrupo;
use App\Models\NivelReferencia;
use App\Models\TipoMuestra;
use App\Models\UnidadMedida;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['usuario' => 'admin'],
            [
                'nombre' => 'Administrador',
                'correo' => 'admin@laboratorioshadai.local',
                'password' => Hash::make('admin12345'),
                'rol' => 'ADMIN',
                'estado' => true,
            ],
        );

        EmpresaConfiguracion::firstOrCreate([
            'nombre_comercial' => 'Laboratorio Shadai',
        ]);

        foreach (['Hematologia', 'Quimica Sanguinea', 'Inmunologia', 'Uroanalisis', 'Parasitologia', 'Microbiologia', 'Otros'] as $index => $nombre) {
            ExamenGrupo::firstOrCreate(['nombre' => $nombre], ['orden' => $index + 1, 'estado' => true]);
        }

        foreach (['Sangre', 'Suero', 'Orina', 'Heces', 'Hisopado', 'Esputo', 'Otro'] as $nombre) {
            TipoMuestra::firstOrCreate(['nombre' => $nombre], ['estado' => true]);
        }

        foreach ([
            ['simbolo' => 'mg/dL', 'nombre' => 'Miligramos por decilitro'],
            ['simbolo' => 'g/dL', 'nombre' => 'Gramos por decilitro'],
            ['simbolo' => 'U/L', 'nombre' => 'Unidades por litro'],
            ['simbolo' => '%', 'nombre' => 'Porcentaje'],
            ['simbolo' => 'mm/h', 'nombre' => 'Milimetros por hora'],
            ['simbolo' => 'cel/uL', 'nombre' => 'Celulas por microlitro'],
            ['simbolo' => 'mEq/L', 'nombre' => 'Miliequivalentes por litro'],
            ['simbolo' => 'UI/mL', 'nombre' => 'Unidades internacionales por mililitro'],
        ] as $unidad) {
            UnidadMedida::firstOrCreate(['simbolo' => $unidad['simbolo']], $unidad + ['estado' => true]);
        }

        foreach ([
            ['nombre' => 'Recien nacido', 'edad_min_dias' => 0, 'edad_max_dias' => 28],
            ['nombre' => 'Lactante', 'edad_min_dias' => 29, 'edad_max_dias' => 730],
            ['nombre' => 'Nino', 'edad_min_dias' => 731, 'edad_max_dias' => 4380],
            ['nombre' => 'Adolescente', 'edad_min_dias' => 4381, 'edad_max_dias' => 6570],
            ['nombre' => 'Adulto', 'edad_min_dias' => 6571, 'edad_max_dias' => 23725],
            ['nombre' => 'Adulto mayor', 'edad_min_dias' => 23726, 'edad_max_dias' => null],
        ] as $nivel) {
            NivelReferencia::firstOrCreate(['nombre' => $nivel['nombre']], $nivel + ['estado' => true]);
        }
    }
}
