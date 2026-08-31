<?php

namespace App\Filament\Resources\FiscalizacaoRegionStatResource\Pages;

use App\Filament\Resources\FiscalizacaoRegionStatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFiscalizacaoRegionStats extends ListRecords
{
    protected static string $resource = FiscalizacaoRegionStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
