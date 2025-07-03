<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\Calendar as CalendarWidget;

class Calendar extends Page
{
    protected string $view = 'filament.pages.calendar';

    protected function getHeaderWidgets(): array
    {
        return [
            CalendarWidget::class
        ];
    }
}
