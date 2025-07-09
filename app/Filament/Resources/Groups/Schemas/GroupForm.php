<?php

namespace App\Filament\Resources\Groups\Schemas;

use App\Models\Section;
use App\Models\SectionPage;
use Filament\Schemas\Schema;
use Filament\Schemas\JsContent;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\Builder;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\FusedGroup;
use Filament\Forms\Components\Builder\Block;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\Repeater\TableColumn;
use App\Filament\Resources\Groups\SectionTypes\SectionPageType;

class GroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([

                // Section Pages
                Tabs::make('SectionPages')
                    ->vertical()
                    ->tabs(function (?Model $record) {
                        $sectionPages = $record->sectionPages;
                        foreach ($sectionPages as $sectionPage) {
                            $tabs[] = Tab::make($sectionPage->name)
                                ->statePath($sectionPage->id)
                                ->schema([
                                    TextInput::make('section_page_name')
                                    ->required(),

                                    Builder::make('content')
                                        ->collapsible()
                                        ->blockNumbers(false)
                                        
                                        ->blocks([
                                            Block::make('Content')
                                                
                                                ->label(function (?array $state): string {
                                                    if ($state === null) {
                                                        return 'Content';
                                                    }

                                                    return $state['title'] ?? 'Titel';
                                                })
                                                ->schema([
                                                    TextInput::make('title')
                                                        ->live(onBlur: true)
                                                        ->required(),
                                                    RichEditor::make('content'),
                                                        
                                                ]),
                                            Block::make('actionsSteps')
                                                ->label('Actiepunten')
                                                ->maxItems(1)
                                                ->schema([
                                                    Repeater::make('actionsSteps')
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
                                                ]),
                                        ])
                                    
                                ]);
                        }
                        
                        return $tabs ?? [];
                    })
            ]);
    }
}
