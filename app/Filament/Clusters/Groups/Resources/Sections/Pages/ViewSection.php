<?php

namespace App\Filament\Clusters\Groups\Resources\Sections\Pages;

use App\Filament\Clusters\Groups\Resources\Sections\SectionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSection extends ViewRecord
{
    protected static string $resource = SectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
