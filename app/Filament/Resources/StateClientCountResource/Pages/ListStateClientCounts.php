<?php

namespace App\Filament\Resources\StateClientCountResource\Pages;

use App\Filament\Resources\StateClientCountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStateClientCounts extends ListRecords
{
    protected static string $resource = StateClientCountResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
