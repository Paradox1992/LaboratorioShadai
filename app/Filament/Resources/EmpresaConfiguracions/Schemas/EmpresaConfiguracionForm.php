<?php

namespace App\Filament\Resources\EmpresaConfiguracions\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EmpresaConfiguracionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre_comercial')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Nombre visible del laboratorio en el sistema y documentos.')
                    ->required(),
                TextInput::make('razon_social')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Nombre legal de la empresa si es diferente al nombre comercial.'),
                TextInput::make('rtn')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Registro tributario de la empresa.'),
                TextInput::make('telefono')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Telefono principal de contacto del laboratorio.')
                    ->tel(),
                TextInput::make('correo')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Correo institucional para contacto o reportes.'),
                Textarea::make('direccion')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Direccion fisica que aparecera en documentos del laboratorio.')
                    ->columnSpanFull(),
                TextInput::make('logo_url')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Enlace o ruta al logo usado en el panel y reportes.')
                    ->url(),
                Toggle::make('estado')
                    ->hintIcon('heroicon-o-question-mark-circle', 'Indica si esta configuracion de empresa esta activa.')
                    ->required(),
            ]);
    }
}
