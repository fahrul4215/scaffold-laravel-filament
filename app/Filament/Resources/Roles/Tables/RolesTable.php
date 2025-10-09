<?php

namespace App\Filament\Resources\Roles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RolesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('guard_name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('permissions.name')
                    ->badge()
                    ->searchable()
                    ->separator(',')
                    ->limit(3)
                    ->placeholder('No permissions'),
                TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Users')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->disabled(fn ($record) => $record->name === 'superadmin'),
                DeleteAction::make()
                    ->disabled(fn ($record) => $record->name === 'superadmin'),
            ])
            ->toolbarActions([
                CreateAction::make(),
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->action(function ($records) {
                            // Filter out superadmin role from bulk delete
                            $records->reject(fn ($record) => $record->name === 'superadmin')->each->delete();
                        }),
                ]),
            ])
            ->defaultSort('name', 'asc');
    }
}
