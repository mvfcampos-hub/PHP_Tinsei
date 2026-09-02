<?php

namespace App\Filament\Resources\CloudPlanResource\Pages;

use App\Filament\Resources\CloudPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCloudPlans extends ListRecords
{
    protected static string $resource = CloudPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
