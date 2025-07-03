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

class BudgetManagement extends Page
{
    use InteractsWithForms;
    
    protected string $view = 'filament.clusters.groups.pages.budget-management';
    protected static null|string $slug = 'budget';
    protected static ?string $cluster = GroupsCluster::class;
    protected static string | BackedEnum | null $navigationIcon = Heroicon::CurrencyEuro;
    protected static ?string $navigationLabel = 'Budgetbeheer';
    protected static ?int $navigationSort = 2;

    public static function getUrl(array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null): string
    {
        return GroupsCluster::getUrl($parameters, $isAbsolute, $panel, $tenant);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
               
            ]);
    }
}
