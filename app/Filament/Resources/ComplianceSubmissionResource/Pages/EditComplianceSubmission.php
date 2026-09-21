<?php

namespace App\Filament\Resources\ComplianceSubmissionResource\Pages;

use App\Filament\Resources\ComplianceSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComplianceSubmission extends EditRecord
{
    protected static string $resource = ComplianceSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
