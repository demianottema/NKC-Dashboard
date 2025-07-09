<?php

namespace App\Filament\Resources\Groups\Pages;

use Throwable;
use App\Models\Section;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Facades\FilamentView;
use App\Filament\Resources\Groups\GroupResource;

class EditGroup extends EditRecord
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([])
                ->label('Acties')
                ->button()
                ->actions([
                    Action::make('manageSections')
                        ->label('Secties beheren')
                        ->icon(Heroicon::ListBullet)
                        ->color('grey'),
                        // ->url()
                    
                    Action::make('createSection')
                        ->label('Sectie aanmaken')
                        ->icon(Heroicon::PlusCircle)
                        ->color('grey'),
                        // ->action()
                    
                    Action::make('groupSettings')
                        ->label('Groepsinstellingen')
                        ->icon(Heroicon::Cog6Tooth)
                        ->color('grey'),
                        // ->url()
                ])
        ];
    }

    public function mount(int | string $section): void
    {
        $this->record = Section::find($section);
        $this->authorizeAccess();
        $this->fillForm();
        $this->previousUrl = url()->previous();
    }
    
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $this->record->sectionPages
            ->mapWithKeys(function ($page) {    
            return [
                $page->id => array_merge(
                    ['section_page_name' => $page->name],
                    $page->content ?? []
                ),
            ];
        })
        ->toArray();
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        foreach ($data as $sectionPageId => $sectionPageData) {
            $sectionPage = \App\Models\SectionPage::find($sectionPageId);

            // Check if the page belongs to the section, and if the user can access the group
            if (
                $sectionPage?->section_id !== $record->id ||
                !$sectionPage?->section?->group?->users->contains(auth()->id())
            ) {
                continue; 
            }

            // Map static properties
            $sectionPageName = $sectionPageData['section_page_name'];

            $sectionPageDataContent = array_diff_key($sectionPageData, array_flip([
                'section_page_name'
            ]));

            $sectionPage->update([
                'name' => $sectionPageName,
                'content' => $sectionPageDataContent,
            ]);
        }

        return $record;
    }
  
}
