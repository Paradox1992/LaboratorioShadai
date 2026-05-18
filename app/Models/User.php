<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser, HasName
{
    use Notifiable, SoftDeletes;

    protected $table = 'usuarios_sistema';

    protected $fillable = [
        'nombre',
        'usuario',
        'correo',
        'password',
        'rol',
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return (bool) $this->estado;
    }

    public function getFilamentName(): string
    {
        return $this->nombre ?: $this->usuario;
    }

    public function getNameAttribute(): string
    {
        return $this->getFilamentName();
    }

    public function dispositivos(): HasMany
    {
        return $this->hasMany(RegisteredDevice::class, 'usuario_id');
    }

    protected function casts(): array
    {
        return [
            'estado' => 'boolean',
            'password' => 'hashed',
        ];
    }
}
