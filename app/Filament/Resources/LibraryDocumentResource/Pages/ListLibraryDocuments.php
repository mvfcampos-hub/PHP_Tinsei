<?php

namespace App\Filament\Resources\LibraryDocumentResource\Pages;

use App\Filament\Resources\LibraryDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLibraryDocuments extends ListRecords
{
    protected static string $resource = LibraryDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
