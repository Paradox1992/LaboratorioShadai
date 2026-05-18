<?php

namespace App\Console\Commands;

use App\Models\RegisteredDevice;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateDeviceRegistrationToken extends Command
{
    protected $signature = 'shadai:device-token {nombre : Nombre del dispositivo} {--usuario= : Usuario del sistema que quedara asociado}';

    protected $description = 'Crea un enlace de registro para autorizar un dispositivo.';

    public function handle(): int
    {
        $token = Str::random(64);
        $usuarioId = null;

        if ($usuario = $this->option('usuario')) {
            $usuarioId = User::query()->where('usuario', $usuario)->value('id');

            if (! $usuarioId) {
                $this->error("No existe el usuario [{$usuario}].");

                return self::FAILURE;
            }
        }

        RegisteredDevice::create([
            'usuario_id' => $usuarioId,
            'nombre' => $this->argument('nombre'),
            'registro_token_hash' => hash('sha256', $token),
            'estado' => true,
        ]);

        $this->info('Abre este enlace una sola vez desde el dispositivo que quieres autorizar:');
        $this->line(rtrim(config('app.url'), '/').'/registrar-dispositivo/'.$token);

        return self::SUCCESS;
    }
}
