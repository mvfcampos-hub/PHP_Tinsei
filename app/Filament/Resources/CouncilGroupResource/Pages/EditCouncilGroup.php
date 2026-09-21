<?php

namespace App\Filament\Resources\CouncilGroupResource\Pages;

use App\Filament\Resources\CouncilGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCouncilGroup extends EditRecord
{
    protected static string $resource = CouncilGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
