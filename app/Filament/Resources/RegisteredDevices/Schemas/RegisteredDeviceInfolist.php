<?php

namespace App\Filament\Resources\RegisteredDevices\Schemas;

use App\Models\RegisteredDevice;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RegisteredDeviceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('usuario.id')
                    ->label('Usuario')
                    ->placeholder('-'),
                TextEntry::make('nombre'),
                TextEntry::make('fingerprint_hash')
                    ->placeholder('-'),
                TextEntry::make('registro_token_hash')
                    ->placeholder('-'),
                TextEntry::make('ip_registro')
                    ->placeholder('-'),
                TextEntry::make('user_agent_registro')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('registrado_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('ultimo_acceso_at')
                    ->dateTime()
                    ->placeholder('-'),
                IconEntry::make('estado')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (RegisteredDevice $record): bool => $record->trashed()),
            ]);
    }
}
