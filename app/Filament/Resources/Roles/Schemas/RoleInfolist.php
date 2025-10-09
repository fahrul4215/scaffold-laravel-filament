<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RoleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Role Name'),
                TextEntry::make('guard_name')
                    ->label('Guard Name'),
                TextEntry::make('permissions.name')
                    ->label('Permissions')
                    ->badge()
                    ->separator(',')
                    ->placeholder('No permissions assigned'),
                TextEntry::make('users_count')
                    ->label('Number of Users')
                    ->state(fn ($record) => $record->users()->count()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
