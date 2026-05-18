<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdenLaboratorio extends Model
{
    use SoftDeletes;

    protected $table = 'ordenes_laboratorio';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'resultado_impreso' => 'boolean',
            'fecha_orden' => 'datetime',
            'fecha_toma_muestra' => 'datetime',
            'fecha_entrega_estimada' => 'datetime',
            'fecha_finalizacion' => 'datetime',
            'fecha_resultado_impreso' => 'datetime',
        ];
    }

    public function ventanillaOrden(): BelongsTo
    {
        return $this->belongsTo(VentanillaOrden::class, 'ventanilla_orden_id');
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function examenesOrdenados(): HasMany
    {
        return $this->hasMany(OrdenExamen::class, 'orden_id');
    }
}
