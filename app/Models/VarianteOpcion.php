<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VarianteOpcion extends Model
{
    use SoftDeletes;

    protected $table = 'variante_opciones';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'estado' => 'boolean',
            'es_normal' => 'boolean',
        ];
    }

    public function variante(): BelongsTo
    {
        return $this->belongsTo(ExamenVariante::class, 'variante_id');
    }
}
