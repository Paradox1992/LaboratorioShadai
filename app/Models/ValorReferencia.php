<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ValorReferencia extends Model
{
    use SoftDeletes;

    protected $table = 'valores_referencia';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'estado' => 'boolean',
            'valor_min' => 'decimal:4',
            'valor_max' => 'decimal:4',
        ];
    }

    public function variante(): BelongsTo
    {
        return $this->belongsTo(ExamenVariante::class, 'variante_id');
    }

    public function nivel(): BelongsTo
    {
        return $this->belongsTo(NivelReferencia::class, 'nivel_id');
    }
}
