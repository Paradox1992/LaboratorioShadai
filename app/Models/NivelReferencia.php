<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class NivelReferencia extends Model
{
    use SoftDeletes;

    protected $table = 'niveles_referencia';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['estado' => 'boolean'];
    }

    public function valoresReferencia(): HasMany
    {
        return $this->hasMany(ValorReferencia::class, 'nivel_id');
    }
}
