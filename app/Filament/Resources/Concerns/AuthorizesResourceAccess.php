<?php

namespace App\Filament\Resources\Concerns;

use App\Models\Paciente;
use App\Models\User;
use App\UserRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

trait AuthorizesResourceAccess
{
    public static function canAccess(): bool
    {
        return static::currentUserCanAccessResource();
    }

    public static function canViewAny(): bool
    {
        return static::currentUserCanAccessResource();
    }

    public static function canCreate(): bool
    {
        return static::currentUserCanAccessResource();
    }

    public static function canView(Model $record): bool
    {
        return static::currentUserCanAccessResource();
    }

    public static function canEdit(Model $record): bool
    {
        return static::currentUserCanAccessResource();
    }

    public static function canDelete(Model $record): bool
    {
        return static::currentUserCanAccessResource();
    }

    public static function canDeleteAny(): bool
    {
        return static::currentUserCanAccessResource();
    }

    public static function canForceDelete(Model $record): bool
    {
        return static::currentUserCanAccessResource();
    }

    public static function canForceDeleteAny(): bool
    {
        return static::currentUserCanAccessResource();
    }

    public static function canReorder(): bool
    {
        return static::currentUserCanAccessResource();
    }

    public static function canReplicate(Model $record): bool
    {
        return static::currentUserCanAccessResource();
    }

    public static function canRestore(Model $record): bool
    {
        return static::currentUserCanAccessResource();
    }

    public static function canRestoreAny(): bool
    {
        return static::currentUserCanAccessResource();
    }

    protected static function currentUserCanAccessResource(): bool
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return false;
        }

        return match ($user->role()) {
            UserRole::Soporte => true,
            UserRole::Operador => static::getNavigationGroup() !== '04. Administracion',
            UserRole::User => static::getNavigationGroup() === '02. Operacion clinica'
                && static::getModel() === Paciente::class,
            default => false,
        };
    }

    abstract public static function getNavigationGroup(): string|UnitEnum|null;

    abstract public static function getModel(): string;
}
