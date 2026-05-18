<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class VentanillaOrden extends Model
{
    use SoftDeletes;

    protected $table = 'ventanilla_ordenes';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'impresa' => 'boolean',
            'fecha_recepcion' => 'datetime',
            'fecha_impresion' => 'datetime',
        ];
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function ordenLaboratorio(): HasOne
    {
        return $this->hasOne(OrdenLaboratorio::class, 'ventanilla_orden_id');
    }
}
