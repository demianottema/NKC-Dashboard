<?php 

namespace App\Filament\Resources\Groups\SectionTypes;

use App\Models\SectionPage;

class BaseType 
{
    public function renderSchemaForType(SectionPage $sectionPage): array
    {
        return [];
    }

    public function hydrateUsingTypeHandler(SectionPage $record): array 
    {
        return $record->content;
    }

    public function saveUsingTypeHandler(SectionPage $record, $data): array
    {
        return $data;
    }
    

}