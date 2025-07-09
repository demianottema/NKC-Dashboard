<?php

namespace App\Filament\Resources\Groups\Schemas;

use App\Models\Section;
use App\Models\SectionPage;
use Filament\Schemas\Schema;
use Filament\Schemas\JsContent;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Group;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
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
                                ->schema(array_merge([
                                    TextInput::make('section_page_name')
                                    ->required(),
                                    
                                ], SectionPageType::renderSchema($sectionPage)));
                        }
                        
                        return $tabs ?? [];
                    })
            ]);
    }
}
