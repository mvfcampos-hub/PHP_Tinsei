<?php

namespace App\Filament\Resources\FiscalizacaoRegionStatResource\Pages;

use App\Filament\Resources\FiscalizacaoRegionStatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFiscalizacaoRegionStat extends EditRecord
{
    protected static string $resource = FiscalizacaoRegionStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
