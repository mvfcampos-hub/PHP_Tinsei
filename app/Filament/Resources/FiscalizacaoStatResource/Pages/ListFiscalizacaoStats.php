<?php

namespace App\Filament\Resources\FiscalizacaoStatResource\Pages;

use App\Filament\Resources\FiscalizacaoStatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFiscalizacaoStats extends ListRecords
{
    protected static string $resource = FiscalizacaoStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
