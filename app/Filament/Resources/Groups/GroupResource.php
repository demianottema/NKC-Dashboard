<?php

namespace App\Filament\Resources\Groups;

use BackedEnum;
use Filament\Panel;
use App\Models\Group;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Pages\BasePage;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Filament\Navigation\NavigationItem;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filament\IsDynamicResource;
use Filament\Pages\Enums\SubNavigationPosition;
use App\Filament\Resources\Groups\Pages\EditGroup;
use App\Filament\Resources\Groups\Pages\ListGroups;
use App\Filament\Resources\Groups\Pages\CreateGroup;
use App\Filament\Resources\Groups\Pages\SectionPage;
use App\Filament\Resources\Groups\Schemas\GroupForm;
use App\Filament\Resources\Groups\Pages\SettingsPage;
use App\Filament\Resources\Groups\Tables\GroupsTable;

class GroupResource extends Resource
{
    use IsDynamicResource;

    protected static ?string $pluralLabel = 'Groep';
    protected static ?string $pluralModelLabel = 'Groepen';
    protected static ?string $model = Group::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Schema $schema): Schema
    {
        return GroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GroupsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGroups::route('groups/'),
            'create' => CreateGroup::route('groups/create'),
            'edit' => EditGroup::route('{slug}/{section}/edit'),
            'settings' => SettingsPage::route('{slug}/'),
        ];
    }

    public static function getPage(): string
    {
        return 'edit';
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return "";
    }

    public static function getUrl(?string $name = null, array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null, bool $shouldGuessMissingParameters = false): string
    {   
        $excludedPaths = ['index', 'create'];

        if (!isset($parameters[static::getIdentifierColumnName()]) && !in_array($name, $excludedPaths)) {
            $parameters[static::getIdentifierColumnName()] = self::resolveIdentifier();           
        }

        if (!isset($parameters['section']) && !in_array($name, [...$excludedPaths, 'settings'])) {
            $parameters['section'] = Cache::remember('group-' . static::getIdentifierColumnName(), 60*60*8, function () use ($parameters) {
                return Group::where('slug', $parameters[static::getIdentifierColumnName()])->first()->sections()->first(['id'])->id ?? 1;
            });     
        }

        unset($parameters['record']);

        return parent::getUrl($name, $parameters, $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        $sections = static::getCurrentActiveRecord()->sections;
        foreach ($sections as $section) {
            $items[] = NavigationItem::make(Str::slug($section->name).$section->id)
                ->url(static::getUrl('edit', ['section' => $section->id]))
                ->icon('heroicon-o-presentation-chart-line')
                ->isActiveWhen(fn () => $section->id === intval(Route::current()->parameter('section')))
                ->sort($section->order_by);
        }
        
        return $items;
    }
}
