<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoMuestra extends Model
{
    use SoftDeletes;

    protected $table = 'tipos_muestra';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['estado' => 'boolean'];
    }

    public function examenes(): HasMany
    {
        return $this->hasMany(Examen::class, 'tipo_muestra_id');
    }
}
