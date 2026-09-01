<?php

namespace App\Filament\Resources\ComplianceSubmissionResource\Pages;

use App\Filament\Resources\ComplianceSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComplianceSubmissions extends ListRecords
{
    protected static string $resource = ComplianceSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
