<?php

use App\Http\Controllers\PrintResultadoController;
use App\Http\Controllers\RegisterDeviceController;
use App\Http\Controllers\TemporaryDeviceTokenController;
use App\Http\Middleware\EnsureRegisteredDevice;
use App\Models\VentanillaOrden;
use App\UserRole;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/admin'));
Route::get('/registrar-dispositivo/{token}', RegisterDeviceController::class)
    ->name('devices.register');

Route::get('/soporte/token-dispositivo', [TemporaryDeviceTokenController::class, 'create'])
    ->middleware('throttle:10,1')
    ->name('temporary-device-token.create');

Route::post('/soporte/token-dispositivo', [TemporaryDeviceTokenController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('temporary-device-token.store');

Route::get('/ventanilla/{ventanillaOrden}/imprimir', function (VentanillaOrden $ventanillaOrden) {
    $ventanillaOrden->load([
        'paciente',
        'usuario',
        'ordenLaboratorio.examenesOrdenados.examen',
    ]);

    return view('prints.ventanilla-orden', [
        'orden' => $ventanillaOrden,
    ]);
})->middleware(['auth', EnsureRegisteredDevice::class, 'role:'.UserRole::Operador->value.','.UserRole::Soporte->value])
    ->name('ventanilla.imprimir');

Route::get('/ordenes-laboratorio/{ordenLaboratorio}/resultados/imprimir', PrintResultadoController::class)
    ->middleware(['auth', EnsureRegisteredDevice::class, 'role:'.UserRole::Operador->value.','.UserRole::Soporte->value])
    ->name('resultados.imprimir');

Route::get('/ordenes-laboratorio/{ordenLaboratorio}/resultados/pdf', [PrintResultadoController::class, 'pdf'])
    ->middleware(['auth', EnsureRegisteredDevice::class, 'role:'.UserRole::Operador->value.','.UserRole::Soporte->value])
    ->name('resultados.pdf');
