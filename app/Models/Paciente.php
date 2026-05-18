<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use SoftDeletes;

    protected $table = 'pacientes';

    protected $guarded = ['id'];

    protected $appends = ['nombre_completo'];

    protected function nombreCompleto(): Attribute
    {
        return Attribute::get(fn (): string => trim("{$this->nombres} {$this->apellidos}"));
    }

    protected function casts(): array
    {
        return [
            'estado' => 'boolean',
            'fecha_nacimiento' => 'date',
        ];
    }

    public function ventanillaOrdenes(): HasMany
    {
        return $this->hasMany(VentanillaOrden::class, 'paciente_id');
    }

    public function ordenesLaboratorio(): HasMany
    {
        return $this->hasMany(OrdenLaboratorio::class, 'paciente_id');
    }
}
