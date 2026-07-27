<?php

namespace App\Filament\Resources\CouncilGroupResource\Pages;

use App\Filament\Resources\CouncilGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCouncilGroups extends ListRecords
{
    protected static string $resource = CouncilGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
