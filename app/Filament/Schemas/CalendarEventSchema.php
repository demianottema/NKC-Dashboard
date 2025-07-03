<?php

namespace App\Filament\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class CalendarEventSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
            ]);
    }
}
