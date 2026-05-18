<?php

namespace App\Filament\Resources\EmpresaConfiguracions\Schemas;

use App\Models\EmpresaConfiguracion;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EmpresaConfiguracionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nombre_comercial'),
                TextEntry::make('razon_social')
                    ->placeholder('-'),
                TextEntry::make('rtn')
                    ->placeholder('-'),
                TextEntry::make('telefono')
                    ->placeholder('-'),
                TextEntry::make('correo')
                    ->placeholder('-'),
                TextEntry::make('direccion')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('logo_url')
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
                    ->visible(fn (EmpresaConfiguracion $record): bool => $record->trashed()),
            ]);
    }
}
