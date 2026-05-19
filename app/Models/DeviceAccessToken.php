<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceAccessToken extends Model
{
    protected $table = 'tokens_acceso_dispositivo';

    protected $fillable = [
        'dispositivo_registrado_id',
        'jwt_id',
        'token_hash',
        'user_agent_hash',
        'ip_address',
        'issued_at',
        'expires_at',
        'last_used_at',
        'revoked_at',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
            'expires_at' => 'datetime',
            'last_used_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(RegisteredDevice::class, 'dispositivo_registrado_id');
    }
}
