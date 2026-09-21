<?php

namespace App\Filament\Resources\FiscalizacaoStatResource\Pages;

use App\Filament\Resources\FiscalizacaoStatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFiscalizacaoStat extends EditRecord
{
    protected static string $resource = FiscalizacaoStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
