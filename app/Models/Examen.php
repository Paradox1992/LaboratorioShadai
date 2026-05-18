<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examen extends Model
{
    use SoftDeletes;

    protected $table = 'examenes';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'estado' => 'boolean',
            'requiere_ayuno' => 'boolean',
            'requiere_muestra' => 'boolean',
        ];
    }

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(ExamenGrupo::class, 'grupo_id');
    }

    public function tipoMuestra(): BelongsTo
    {
        return $this->belongsTo(TipoMuestra::class, 'tipo_muestra_id');
    }

    public function variantes(): HasMany
    {
        return $this->hasMany(ExamenVariante::class, 'examen_id');
    }
}
