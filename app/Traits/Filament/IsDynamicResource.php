<?php

namespace App\Traits\Filament;

use Filament\Panel;
use Illuminate\Support\Facades\Route;
use Filament\Navigation\NavigationItem;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Htmlable;

trait IsDynamicResource 
{
    protected static string $page = 'index';
    protected static int $maxGroupsModelsCount = 2;
    protected static ?string $groupLabel = null;
    protected static string $identifierColumnName = 'slug';
    protected static string $labelColumnName = 'name';
    protected static ?string $iconColumnName = 'icon';
    protected static ?Model $currentActiveRecord = null;
    
    public static function getUrl(?string $name = null, array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null, bool $shouldGuessMissingParameters = false): string
    {
        if (!isset($parameters[static::getIdentifierColumnName()])) {
            $parameters[static::getIdentifierColumnName()] = self::resolveIdentifier();           
        }

        return parent::getUrl($name, $parameters, $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);
    }

    public static function resolveIdentifier()
    {
        if (! is_null(Route::current()->parameter(static::getIdentifierColumnName()))) {
            return Route::current()->parameter(static::getIdentifierColumnName());
        }

        if (! is_null(Route::getRoutes()->match(request()->create(url()->previousPath()))->parameter(static::getIdentifierColumnName()))) {
            return Route::getRoutes()->match(request()->create(url()->previousPath()))->parameter(static::getIdentifierColumnName());
        }
        
        return null;
    }

    public static function getNavigationItems(): array
    {
        $models = static::getModel()::all();

        if (count($models) > static::getMaxModelsCount()) {
            $items[] = NavigationItem::make('manageItems')
                ->isActiveWhen(fn () => url(Route::current()->uri()) === self::getUrl('index'))
                ->label(static::getGroupLabel() . ' beheren')
                ->icon(Heroicon::RectangleStack)
                ->sort(5)
                ->url(self::getUrl('index'));
        }

        foreach ($models as $model) {
            $items[] = NavigationItem::make($model[static::getIdentifierColumnName()])
                ->group(count($models) > static::getMaxModelsCount() ? static::getGroupLabel() : '')
                ->isActiveWhen(fn () => Route::current()->parameter(static::getIdentifierColumnName()) == $model[static::getIdentifierColumnName()])
                ->label($model[static::getLabelColumnName()])
                ->icon(!is_null(static::getIconColumnName()) ? $model[static::getIconColumnName()] : null)
                ->sort(5)
                ->url(static::getUrl(static::getPage(), [static::getIdentifierColumnName() => $model[static::getIdentifierColumnName()]]));
        }

        return $items ?? [];
    }

    public static function getCurrentActiveRecord(): ?Model
    {
        if (is_null(static::$currentActiveRecord)) {
            static::$currentActiveRecord = static::getModel()::where(
                static::getIdentifierColumnName(),
                self::resolveIdentifier()
            )->first();
        }

        return static::$currentActiveRecord ?? null;
    }

    public static function getRecordTitleAttribute(): string
    {
        return static::getCurrentActiveRecord()[static::getLabelColumnName()] ?? '';
    }

    public static function getRecordTitle(?Model $record): string | Htmlable | null
    {
        return static::getCurrentActiveRecord()[static::getLabelColumnName()] ?? $record?->getAttribute(static::getRecordTitleAttribute()) ?? static::getModelLabel();
    }

    public static function getHeading(): string
    {
        return static::getCurrentActiveRecord()[static::getLabelColumnName()];
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return "{".static::getIdentifierColumnName()."}";
    }

    public static function getMaxModelsCount(): int
    {
        return static::$maxGroupsModelsCount;
    }

    public static function getPage(): string
    {
        return static::$page;
    }

    public static function getGroupLabel(): string
    {
        return static::$groupLabel ?? static::getPluralModelLabel();
    }

    public static function getIdentifierColumnName(): string
    {
        return static::$identifierColumnName;
    }

    public static function getLabelColumnName(): string
    {
        return static::$labelColumnName;
    }

    public static function getIconColumnName(): ?string
    {
        return static::$iconColumnName;
    }
}
