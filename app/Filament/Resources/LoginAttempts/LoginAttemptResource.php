<?php

namespace App\Filament\Resources\LoginAttempts;

use App\Filament\Resources\LoginAttempts\Pages\ManageLoginAttempts;
use App\Models\LoginAttempt;
use BackedEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LoginAttemptResource extends Resource
{
    protected static ?string $model = LoginAttempt::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationLabel = 'Login Attempts';

    protected static ?string $pluralLabel = 'Login Attempts';

    protected static string|\UnitEnum|null $navigationGroup = 'System';

    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false; // Read-only resource
    }

    public static function canEdit($record): bool
    {
        return false; // Read-only resource
    }

    public static function canDelete($record): bool
    {
        return false; // Read-only resource
    }

    public static function canDeleteAny(): bool
    {
        return false; // Read-only resource
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('superadmin');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->disabled(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->disabled(),
                TextInput::make('status')
                    ->disabled(),
                TextInput::make('ip_address')
                    ->disabled(),
                Textarea::make('user_agent')
                    ->disabled()
                    ->columnSpanFull(),
                TextInput::make('location')
                    ->disabled(),
                Textarea::make('failure_reason')
                    ->disabled()
                    ->columnSpanFull(),
                DateTimePicker::make('attempted_at')
                    ->disabled(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('attempted_at', 'desc')
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->default('Unknown')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success' => 'success',
                        'failed' => 'danger',
                        'logout' => 'info',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('location')
                    ->label('Location')
                    ->default('Unknown')
                    ->searchable(),
                TextColumn::make('failure_reason')
                    ->label('Failure Reason')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->failure_reason)
                    ->toggleable(),
                TextColumn::make('attempted_at')
                    ->label('Date & Time')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'success' => 'Success',
                        'failed' => 'Failed',
                        'logout' => 'Logout',
                    ]),
                SelectFilter::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageLoginAttempts::route('/'),
        ];
    }
}
