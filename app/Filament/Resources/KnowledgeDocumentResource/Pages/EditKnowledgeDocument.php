<?php

namespace App\Filament\Resources\KnowledgeDocumentResource\Pages;

use App\Filament\Resources\KnowledgeDocumentResource;
use App\Jobs\ProcessKnowledgeDocument;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditKnowledgeDocument extends EditRecord
{
    protected static string $resource = KnowledgeDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('reprocess')
                ->label('Reprocessar')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->action(function () {
                    ProcessKnowledgeDocument::dispatch($this->record->id);

                    Notification::make()
                        ->title('Reprocessamento iniciado')
                        ->body('O documento será reprocessado em segundo plano.')
                        ->success()
                        ->send();
                }),
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Só reprocessa automaticamente quando o conteúdo-fonte realmente
        // mudou — evita chamadas repetidas (e custo) à API de embeddings
        // para edições que não afetam o texto, como ativar/desativar o
        // documento. Para forçar um novo processamento sem alterar o
        // conteúdo, use o botão "Reprocessar".
        if ($this->record->wasChanged(['file_path', 'raw_text', 'source_type'])) {
            ProcessKnowledgeDocument::dispatch($this->record->id);
        }
    }
}
