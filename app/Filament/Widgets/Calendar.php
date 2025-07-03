<?php

namespace App\Filament\Widgets;

use Filament\Schemas\Schema;
use App\Models\CalendarEvent;
use Illuminate\Support\Collection;
use Filament\Forms\Components\TextInput;
use Guava\Calendar\Actions\CreateAction;
use Guava\Calendar\Widgets\CalendarWidget as BaseCalendarWidget;
use Guava\Calendar\ValueObjects\CalendarEvent as BaseCalendarEvent;

class Calendar extends BaseCalendarWidget
{
    protected bool $eventClickEnabled = true;
    protected bool $eventResizeEnabled = true;
    protected bool $eventDragEnabled = true;
    protected bool $dateClickEnabled = true;
    protected bool $dateSelectEnabled = true;

    public $calendarEventSchema;

    public function getEvents(array $fetchInfo = []): Collection | array
    {
        // return CalendarEvent::all();
        return [BaseCalendarEvent::make()
                ->title('My first event')
                ->start(today())
                ->end(today())];
    }

    public function getDateSelectContextMenuActions(): array
    {
        return [
            CreateAction::make('foo')
                ->model(CalendarEvent::class)
                ->mountUsing(fn ($arguments, $form) => $form->fill([
                    'starts_at' => data_get($arguments, 'startStr'),
                    'ends_at' => data_get($arguments, 'endStr'),
                ])),
        ];
    }
}
