<?php

namespace App\Filament\Resources\MspWorkstationTierResource\Pages;

use App\Filament\Resources\MspWorkstationTierResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMspWorkstationTiers extends ListRecords
{
    protected static string $resource = MspWorkstationTierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
