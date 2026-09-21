<?php

namespace App\Filament\Resources\EducationInstitutionResource\Pages;

use App\Filament\Resources\EducationInstitutionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEducationInstitution extends EditRecord
{
    protected static string $resource = EducationInstitutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
