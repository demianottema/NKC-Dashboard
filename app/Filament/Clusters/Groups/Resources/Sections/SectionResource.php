<?php

namespace App\Filament\Clusters\Groups\Resources\Sections;

use BackedEnum;
use App\Models\Group;
use App\Models\Section;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Route;
use Filament\Navigation\NavigationItem;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Clusters\Groups\GroupsCluster;
use App\Filament\Clusters\Groups\Resources\Sections\Pages\EditSection;
use App\Filament\Clusters\Groups\Resources\Sections\Pages\ViewSection;
use App\Filament\Clusters\Groups\Resources\Sections\Pages\ListSections;
use App\Filament\Clusters\Groups\Resources\Sections\Pages\CreateSection;
use App\Filament\Clusters\Groups\Resources\Sections\Schemas\SectionForm;
use App\Filament\Clusters\Groups\Resources\Sections\Tables\SectionsTable;
use App\Filament\Clusters\Groups\Resources\Sections\Pages\BudgetManagement;
use App\Filament\Clusters\Groups\Resources\Sections\Schemas\SectionInfolist;

class SectionResource extends Resource
{
    protected static ?string $model = Section::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $cluster = GroupsCluster::class;

    protected static ?string $slug = ' ';

    /**
     * Overwrite the default navigation label
     */
    public static function getNavigationItems(): array
    {
        foreach (Group::where('slug', GroupsCluster::getGroupSlug())->first()?->sections ?? [] as $section) {
            $items[] = NavigationItem::make($section["id"])
                ->group(static::getNavigationGroup())
                ->parentItem(static::getNavigationParentItem())
                ->icon(static::getNavigationIcon())
                ->activeIcon(static::getActiveNavigationIcon())
                ->isActiveWhen(fn () => Route::current()->parameter('id') == $section["id"])
                ->badge(static::getNavigationBadge(), color: static::getNavigationBadgeColor())
                ->badgeTooltip(static::getNavigationBadgeTooltip())
                ->sort(static::getNavigationSort())
                ->label($section["name"])
                ->url(static::getUrl('index', ['id' => $section["id"]]));
        }

        return $items ?? [];
    }

    public static function getUrl(?string $name = null, array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null, bool $shouldGuessMissingParameters = false): string
    {
        if (!isset($parameters['slug'])) {
            $parameters['slug'] = GroupsCluster::getGroupSlug();           
        }

        if (!isset($parameters['id'])) {
            $parameters['id'] = Group::where('slug', GroupsCluster::getGroupSlug())->first()?->sections()->first();
        }

        return parent::getUrl($name, $parameters, $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);
    }


    public static function form(Schema $schema): Schema
    {
        return SectionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SectionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SectionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSections::route('{id}/'),
            'create' => CreateSection::route('{id}/create'),
            'view' => ViewSection::route('{id}/{record}'),
            'edit' => EditSection::route('{id}/{record}/edit'),
        ];
    }
}
