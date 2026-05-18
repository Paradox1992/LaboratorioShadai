<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamenGrupo extends Model
{
    use SoftDeletes;

    protected $table = 'examen_grupos';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['estado' => 'boolean'];
    }

    public function examenes(): HasMany
    {
        return $this->hasMany(Examen::class, 'grupo_id');
    }
}
