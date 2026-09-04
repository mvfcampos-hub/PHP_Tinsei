<?php

namespace App\Filament\Resources\BackupPlanResource\Pages;

use App\Filament\Resources\BackupPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBackupPlan extends EditRecord
{
    protected static string $resource = BackupPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
