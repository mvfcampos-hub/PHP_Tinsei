<?php

namespace App\Filament\Resources\MunicipalityProfessionalCountResource\Pages;

use App\Filament\Resources\MunicipalityProfessionalCountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMunicipalityProfessionalCount extends EditRecord
{
    protected static string $resource = MunicipalityProfessionalCountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
