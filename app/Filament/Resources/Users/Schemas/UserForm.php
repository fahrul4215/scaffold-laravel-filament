<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255)
                    ->revealable()
                    ->helperText('Leave blank to keep current password')
                    ->columnSpanFull(),
                Select::make('roles')
                    ->relationship('roles', 'name', fn ($query) => $query->where('name', '!=', 'superadmin'))
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->placeholder('Select roles')
                    ->helperText('Assign one or more roles to this user')
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
