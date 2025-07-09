<?php

namespace App\Filament\Resources\Groups\Tables;

use App\Models\Group;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextInputColumn;
use App\Filament\Resources\Groups\GroupResource;

class GroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Group $record): string => GroupResource::getUrl('edit', ['slug' => $record->slug]))
            ->columns([
                TextColumn::make('name')
                    ->label('Groepnaam')
                    ->grow(),
                
                ImageColumn::make('users.avatar')
                    ->label('Leden')
                    ->imageHeight(40)
                    ->circular()
                    ->stacked()
                    ->overlap(5)
                    ->limit(5)
                    ->ring(5)
                    ->limitedRemainingText(),
            ])
            ->recordActions([
                Action::make('settings')
                    ->url(fn (Group $record): string => GroupResource::getUrl('settings', ['slug' => $record->slug]))
                    ->label('Instellingen')
                    ->icon(Heroicon::Cog6Tooth),

                Action::make('open')
                    ->url(fn (Group $record): string => GroupResource::getUrl('edit', ['slug' => $record->slug]))
                    ->label('Bekijken')
                    ->icon(Heroicon::Eye),
            ]);
    }
}
