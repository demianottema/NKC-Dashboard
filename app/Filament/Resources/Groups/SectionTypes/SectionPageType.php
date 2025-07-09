<?php 

namespace App\Filament\Resources\Groups\SectionTypes;

use App\Models\SectionPage;
use App\Filament\Resources\Groups\SectionTypes\BaseType;
use App\Filament\Resources\Groups\SectionTypes\Types\MeetingType;


class SectionPageType
{
    public static function getTypes(): array {
        return [
            MeetingType::class
        ];
    }

    private static function getTypeClassForRecord(SectionPage $sectionPage): BaseType {
        return new $sectionPage->type(); 
    }

    public static function saveRecord(SectionPage $sectionRecord, $data) 
    {
        $typeClass = self::getTypeClassForRecord($sectionRecord);
        return $typeClass->saveUsingTypeHandler($sectionRecord, $data);
    }

    public static function renderSchema(?SectionPage $sectionRecord) 
    {
        $typeClass = self::getTypeClassForRecord($sectionRecord);
        return $typeClass->renderSchemaForType($sectionRecord);
    }
    
    public static function hydrateRecord(?SectionPage $sectionRecord = null) 
    {
        $typeClass = self::getTypeClassForRecord($sectionRecord);
        return $typeClass->hydrateUsingTypeHandler($sectionRecord);
    }

}