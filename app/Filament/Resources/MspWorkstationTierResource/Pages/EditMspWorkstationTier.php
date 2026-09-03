<?php

namespace App\Filament\Resources\MspWorkstationTierResource\Pages;

use App\Filament\Resources\MspWorkstationTierResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMspWorkstationTier extends EditRecord
{
    protected static string $resource = MspWorkstationTierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
