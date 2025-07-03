<?php

namespace App\Filament\Clusters\Groups\Pages;

use BackedEnum;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Facades\Filament;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use GalleryJsonMedia\Form\JsonMediaGallery;
use App\Filament\Clusters\Groups\GroupsCluster;
use Filament\Forms\Concerns\InteractsWithForms;

class DocumentManagement extends Page
{
    use InteractsWithForms;
    
    protected string $view = 'filament.clusters.groups.pages.document-management';
    protected static null|string $slug = 'settings';
    protected static ?string $cluster = GroupsCluster::class;
    protected static string | BackedEnum | null $navigationIcon = Heroicon::Cog6Tooth;
    protected static ?string $navigationLabel = 'Groepsinstellingen';
    protected static ?int $navigationSort = 1;

    public static function getUrl(array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null): string
    {
        return GroupsCluster::getUrl($parameters, $isAbsolute, $panel, $tenant);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                JsonMediaGallery::make('images')
                    // ->directory('page')
                    // ->reorderable()
                    // ->preserveFilenames()
                    // ->acceptedFileTypes()
                    // ->visibility() // only public for now - NO S3
                    // ->maxSize(4 * 1024)
                    // ->minSize()
                    // ->maxFiles()
                    // ->minFiles()
                    // ->replaceNameByTitle() // If you want to show title (alt customProperties) against file name
                    // // ->image() // only images by default , u need to choose one (images or document)
                    // // ->document() // only documents (eg: pdf, doc, xls,...)
                    // ->downloadable()
                    // ->deletable()
                    // ->withCustomProperties(
                    //     customPropertiesSchema: [
                                
                    //         ],
                    //     editCustomPropertiesOnSlideOver: true,
                    //     editCustomPropertiesTitle: "Edit customs properties"
                    // )
            ]);
    }
}
