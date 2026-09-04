<?php

namespace App\Filament\Resources\KnowledgeDocumentResource\Pages;

use App\Filament\Resources\KnowledgeDocumentResource;
use App\Jobs\ProcessKnowledgeDocument;
use Filament\Resources\Pages\CreateRecord;

class CreateKnowledgeDocument extends CreateRecord
{
    protected static string $resource = KnowledgeDocumentResource::class;

    protected function afterCreate(): void
    {
        ProcessKnowledgeDocument::dispatch($this->record->id);
    }
}
