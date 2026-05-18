<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdenExamen extends Model
{
    use SoftDeletes;

    protected $table = 'orden_examenes';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['requiere_ayuno_snapshot' => 'boolean'];
    }

    public function orden(): BelongsTo
    {
        return $this->belongsTo(OrdenLaboratorio::class, 'orden_id');
    }

    public function examen(): BelongsTo
    {
        return $this->belongsTo(Examen::class, 'examen_id');
    }

    public function resultados(): HasMany
    {
        return $this->hasMany(ResultadoExamen::class, 'orden_examen_id');
    }
}
