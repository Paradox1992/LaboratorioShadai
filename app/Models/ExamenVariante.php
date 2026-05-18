<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamenVariante extends Model
{
    use SoftDeletes;

    protected $table = 'examen_variantes';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'estado' => 'boolean',
            'permite_decimales' => 'boolean',
            'obligatorio' => 'boolean',
        ];
    }

    public function examen(): BelongsTo
    {
        return $this->belongsTo(Examen::class, 'examen_id');
    }

    public function unidadMedida(): BelongsTo
    {
        return $this->belongsTo(UnidadMedida::class, 'unidad_medida_id');
    }

    public function valoresReferencia(): HasMany
    {
        return $this->hasMany(ValorReferencia::class, 'variante_id');
    }

    public function opciones(): HasMany
    {
        return $this->hasMany(VarianteOpcion::class, 'variante_id');
    }
}
