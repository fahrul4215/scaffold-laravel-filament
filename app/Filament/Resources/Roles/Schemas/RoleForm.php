<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('Role name (e.g., admin, editor, viewer)')
                    ->disabled(fn ($record) => $record?->name === 'superadmin')
                    ->dehydrated(fn ($record) => $record?->name !== 'superadmin')
                    ->rule(function ($record) {
                        return function ($attribute, $value, $fail) use ($record) {
                            if (strtolower($value) === 'superadmin' && (!$record || $record->name !== 'superadmin')) {
                                $fail('The superadmin role cannot be created or modified.');
                            }
                        };
                    })
                    ->columnSpanFull(),
                TextInput::make('guard_name')
                    ->default('web')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Guard name (usually "web")')
                    ->disabled(fn ($record) => $record?->name === 'superadmin')
                    ->dehydrated(fn ($record) => $record?->name !== 'superadmin')
                    ->columnSpanFull(),
                Select::make('permissions')
                    ->relationship('permissions', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->placeholder('Select permissions')
                    ->helperText('Assign permissions to this role')
                    ->disabled(fn ($record) => $record?->name === 'superadmin')
                    ->dehydrated(fn ($record) => $record?->name !== 'superadmin')
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
