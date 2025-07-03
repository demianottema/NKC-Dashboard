<?php

namespace App\Filament\Clusters\Groups\Pages;

use BackedEnum;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Facades\Filament;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use App\Filament\Clusters\Groups\GroupsCluster;
use Filament\Forms\Concerns\InteractsWithForms;

class GroupSettings extends Page
{
    use InteractsWithForms;
    
    protected string $view = 'filament.clusters.groups.pages.group-settings';
    protected static null|string $slug = 'settings';
    protected static ?string $cluster = GroupsCluster::class;
    protected static string | BackedEnum | null $navigationIcon = Heroicon::Cog6Tooth;
    protected static ?string $navigationLabel = 'Groepsinstellingen';
    protected static ?int $navigationSort = 1;

    public static function getUrl(array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null): string
    {
        return GroupsCluster::getUrl($parameters, $isAbsolute, $panel, $tenant);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        FileUpload::make('image')
                            ->hiddenLabel()
                            ->image(),
                        Grid::make(1)
                            ->schema([
                                TextInput::make('name')
                                    ->columnSpanFull()
                                    ->required(),
                                Textarea::make('description')
                                    ->columnSpanFull(),
                            ])
                ]),

                // Tabs with the settings
                Tabs::make('Tabs')
                    ->hiddenLabel()
                    ->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make('Gebruikers')
                            ->schema([
                                Select::make('users')
                                    ->relationship(titleAttribute: 'name')
                                    ->label('Teamleden')
                                    ->multiple()
                                    ->dehydrated(false)
                                    ->options(User::query()->pluck('name', 'id'))
                                    ->searchable(true)
                            ]),
                        Tabs\Tab::make('Instellingen')
                            ->schema([
                                Toggle::make('has_file_management')
                                    ->label('Documentenbeheer')
                            ]),
                        Tabs\Tab::make('Budgetten')
                            ->schema([
                                Toggle::make('has_budget_management')
                                    ->label('Groep heeft budgetten')
                            ]),
                        Tabs\Tab::make('Afspraken')
                            ->schema([
                                RichEditor::make('agreements')
                                    ->hiddenLabel()
                            ]),
                        Tabs\Tab::make('Notities')
                            ->schema([
                                RichEditor::make('notes')
                                    ->hiddenLabel()
                            ]),
                    ])
            ]);
    }
}
