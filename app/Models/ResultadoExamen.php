<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultadoExamen extends Model
{
    use SoftDeletes;

    protected $table = 'resultados_examen';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'resultado_numero' => 'decimal:4',
            'ref_valor_min' => 'decimal:4',
            'ref_valor_max' => 'decimal:4',
            'fecha_validacion' => 'datetime',
        ];
    }

    public function ordenExamen(): BelongsTo
    {
        return $this->belongsTo(OrdenExamen::class, 'orden_examen_id');
    }

    public function variante(): BelongsTo
    {
        return $this->belongsTo(ExamenVariante::class, 'variante_id');
    }

    public function valorReferencia(): BelongsTo
    {
        return $this->belongsTo(ValorReferencia::class, 'valor_referencia_id');
    }

    public function validador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validado_por');
    }
}
