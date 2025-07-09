<?php

namespace App\Filament\Resources\Groups\Pages;

use App\Models\Group;
use App\Models\Section;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Tabs;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Tabs\Tab;
use App\Filament\Resources\Groups\GroupResource;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Concerns\CanUseDatabaseTransactions;
use Filament\Pages\Concerns\HasUnsavedDataChangesAlert;
use Filament\Resources\Pages\Concerns\HasRelationManagers;

/**
 * @property-read Schema $form
 */
class SettingsPage extends Page
{
    public ?array $data = [];
    public ?string $previousUrl = null;
    protected static string $resource = GroupResource::class;
    protected ?Model $record = null;

    public function mount(int | string $slug): void
    {
        $this->record = Group::where('slug', $slug)->first();
        $this->previousUrl = url()->previous();
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('test')
                    ->label($this->record->slug)
                    
           ]
        );
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        $hasFormWrapper = $this->hasFormWrapper();

        return Action::make('save')
            ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
            ->submit($hasFormWrapper ? $this->getSubmitFormLivewireMethodName() : null)
            ->action($hasFormWrapper ? null : $this->getSubmitFormLivewireMethodName())
            ->keyBindings(['mod+s']);
    }
}
