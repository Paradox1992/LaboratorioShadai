<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnidadMedida extends Model
{
    use SoftDeletes;

    protected $table = 'unidades_medida';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['estado' => 'boolean'];
    }

    public function variantes(): HasMany
    {
        return $this->hasMany(ExamenVariante::class, 'unidad_medida_id');
    }
}
