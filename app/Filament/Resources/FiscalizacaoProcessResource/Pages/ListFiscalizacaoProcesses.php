<?php

namespace App\Filament\Resources\FiscalizacaoProcessResource\Pages;

use App\Filament\Resources\FiscalizacaoProcessResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFiscalizacaoProcesses extends ListRecords
{
    protected static string $resource = FiscalizacaoProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
