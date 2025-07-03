<?php

namespace App\Models;

use Guava\Calendar\Contracts\Eventable;
use Illuminate\Database\Eloquent\Model;
use Guava\Calendar\ValueObjects\CalendarEvent as BaseCalendarEvent;

class CalendarEvent extends Model implements Eventable
{
    public function toCalendarEvent(): BaseCalendarEvent|array {
        return BaseCalendarEvent::make($this)
            ->title($this->title)
            ->start($this->starts_at)
            ->end($this->ends_at);
    }
}
