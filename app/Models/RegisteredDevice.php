<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegisteredDevice extends Model
{
    use SoftDeletes;

    protected $table = 'dispositivos_registrados';

    protected $fillable = [
        'usuario_id',
        'nombre',
        'fingerprint_hash',
        'registro_token_hash',
        'ip_registro',
        'user_agent_registro',
        'registrado_at',
        'ultimo_acceso_at',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'estado' => 'boolean',
            'registrado_at' => 'datetime',
            'ultimo_acceso_at' => 'datetime',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function accessTokens(): HasMany
    {
        return $this->hasMany(DeviceAccessToken::class, 'dispositivo_registrado_id');
    }
}
