<?php

use App\Http\Controllers\PrintResultadoController;
use App\Http\Controllers\RegisterDeviceController;
use App\Http\Middleware\EnsureRegisteredDevice;
use App\Models\VentanillaOrden;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/admin'));
Route::get('/registrar-dispositivo/{token}', RegisterDeviceController::class)
    ->name('devices.register');

Route::get('/ventanilla/{ventanillaOrden}/imprimir', function (VentanillaOrden $ventanillaOrden) {
    $ventanillaOrden->load([
        'paciente',
        'usuario',
        'ordenLaboratorio.examenesOrdenados.examen',
    ]);

    return view('prints.ventanilla-orden', [
        'orden' => $ventanillaOrden,
    ]);
})->middleware(['auth', EnsureRegisteredDevice::class])
    ->name('ventanilla.imprimir');

Route::get('/ordenes-laboratorio/{ordenLaboratorio}/resultados/imprimir', PrintResultadoController::class)
    ->middleware(['auth', EnsureRegisteredDevice::class])
    ->name('resultados.imprimir');

Route::get('/ordenes-laboratorio/{ordenLaboratorio}/resultados/pdf', [PrintResultadoController::class, 'pdf'])
    ->middleware(['auth', EnsureRegisteredDevice::class])
    ->name('resultados.pdf');
