<?php

namespace App\Filament\Resources\EducationInstitutionResource\Pages;

use App\Filament\Resources\EducationInstitutionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEducationInstitutions extends ListRecords
{
    protected static string $resource = EducationInstitutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('import')
                ->label('Importar planilha')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('gray')
                ->url(fn () => static::getResource()::getUrl('import')),
            Actions\CreateAction::make(),
        ];
    }
}
