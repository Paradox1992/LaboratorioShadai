<?php

namespace App;

enum UserRole: string
{
    case User = 'USER';
    case Operador = 'OPERADOR';
    case Soporte = 'SOPORTE';

    public function label(): string
    {
        return match ($this) {
            self::User => 'User',
            self::Operador => 'Operador',
            self::Soporte => 'Soporte',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $role): array => [$role->value => $role->label()])
            ->all();
    }

    public static function fromStoredValue(?string $role): ?self
    {
        return match ($role) {
            'USUARIO' => self::User,
            'ADMIN' => self::Soporte,
            default => self::tryFrom((string) $role),
        };
    }
}
