<?php

namespace App\Filament\Clusters\Groups;

use BackedEnum;
use Filament\Panel;
use Filament\Clusters\Cluster;
use Filament\Facades\Filament;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Route;
use Filament\Navigation\NavigationItem;
use Illuminate\Database\Eloquent\Model;

class GroupsCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;
    protected static ?string $slug = '{slug}';
    
    public static function getNavigationItems(): array
    {
        $groups = auth()->user()->groups ?? [];
        
        foreach ($groups as $group) {
            $items[] = NavigationItem::make($group["slug"])
                ->group(count($groups) > 2 ? 'Groepen' : '')
                ->isActiveWhen(fn () => Route::current()->parameter('slug') == $group["slug"])
                ->label($group["name"])
                ->sort(5)
                ->url(static::getUrl(["slug" => $group["slug"]]));
        }

        return $items ?? [];
    }

    public static function getUrl(array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null): string
    {
        if (!isset($parameters['slug'])) {
            $parameters['slug'] = self::getGroupSlug();           
        }

        if (blank($panel) || ($panel = Filament::getPanel($panel))->hasTenancy()) {
            $parameters['tenant'] ??= ($tenant ?? Filament::getTenant());
        }

        return route(static::getRouteName($panel), $parameters, $isAbsolute);
    }

    public static function getGroupSlug()
    {
        if (! is_null(Route::current()->parameter('slug'))) {
            return Route::current()->parameter('slug');
        }

        if (! is_null(Route::getRoutes()->match(request()->create(url()->previousPath()))->parameter('slug'))) {
            return Route::getRoutes()->match(request()->create(url()->previousPath()))->parameter('slug');
        }
        
        return null;
    }
}
