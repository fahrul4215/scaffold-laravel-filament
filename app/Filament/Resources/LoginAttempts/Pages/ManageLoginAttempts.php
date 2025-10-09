<?php

namespace App\Filament\Resources\LoginAttempts\Pages;

use App\Filament\Resources\LoginAttempts\LoginAttemptResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageLoginAttempts extends ManageRecords
{
    protected static string $resource = LoginAttemptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
