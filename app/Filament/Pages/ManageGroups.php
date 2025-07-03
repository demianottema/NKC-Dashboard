<?php

namespace App\Filament\Pages;

use App\Models\Group;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use App\Filament\Clusters\Groups\GroupsCluster;
use Filament\Tables\Concerns\InteractsWithTable;

class ManageGroups extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.manage-groups';
    protected static null|string $slug = 'groups';
    protected static ?string $navigationLabel = 'Groepen beheer';

    public static function table(Table $table): Table
    {
         return $table
            ->query(Group::query())
            ->columns([
                TextColumn::make('name')
            ])
            ->recordActions([
                Action::make('settings')
                    ->icon(Heroicon::Cog6Tooth)
                    ->label('Instellingen')
                    ->url(fn (Model $record): string => GroupsCluster::getUrl(['slug' => $record->slug])),
                
            ])
            ->recordUrl(fn (Model $record): string => GroupsCluster::getUrl(['slug' => $record->slug]));
    }
}
