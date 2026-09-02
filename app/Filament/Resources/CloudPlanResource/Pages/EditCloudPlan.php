<?php

namespace App\Filament\Resources\CloudPlanResource\Pages;

use App\Filament\Resources\CloudPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCloudPlan extends EditRecord
{
    protected static string $resource = CloudPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
