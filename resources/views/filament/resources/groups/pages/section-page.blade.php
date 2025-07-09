
@php
    use Filament\Pages\Enums\SubNavigationPosition;

    $subNavigation = $this->getCachedSubNavigation();
@endphp

<x-filament-panels::page>
    <x-filament-panels::page.sub-navigation.tabs
        :navigation="$subNavigation"
    />
    
    {{ $this->content }}
</x-filament-panels::page>


