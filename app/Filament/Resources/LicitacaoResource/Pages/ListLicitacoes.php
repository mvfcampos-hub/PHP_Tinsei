<?php

namespace App\Filament\Resources\LicitacaoResource\Pages;

use App\Filament\Resources\LicitacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLicitacoes extends ListRecords
{
    protected static string $resource = LicitacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
