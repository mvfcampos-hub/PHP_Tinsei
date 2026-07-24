<?php

namespace App\Filament\Resources\MunicipalityProfessionalCountResource\Pages;

use App\Filament\Resources\MunicipalityProfessionalCountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMunicipalityProfessionalCounts extends ListRecords
{
    protected static string $resource = MunicipalityProfessionalCountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
