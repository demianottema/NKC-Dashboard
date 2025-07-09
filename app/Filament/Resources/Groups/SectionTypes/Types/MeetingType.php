<?php 

namespace App\Filament\Resources\Groups\SectionTypes\Types;

use DateTime;
use App\Models\SectionPage;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\FusedGroup;
use Filament\Forms\Components\Repeater\TableColumn;
use App\Filament\Resources\Groups\SectionTypes\BaseType;

class MeetingType extends BaseType
{
    public function renderSchemaForType(SectionPage $sectionPage): array
    {
        return [
            // ActionsSteps
            Repeater::make('actionSteps')
                ->label('Actiepunten')
                   ->table([
                        TableColumn::make('Wie?'),
                        TableColumn::make('Wat?'),
                        TableColumn::make('Wanneer?'),
                    ])
                    ->schema([
                        Select::make('users')
                            // Should be enabled if https://github.com/filamentphp/filament/issues/16841 is fixed
                            // ->multiple() 
                            ->hiddenLabel()
                            ->options(fn () => $sectionPage->section->group->users->pluck('name', 'id')->toArray())
                            ->required(),

                        TextInput::make('title')
                            ->hiddenLabel(),
                        
                        DatePicker::make('deadline')

                    ])
        ];
    }
}