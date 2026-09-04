<?php

namespace App\Jobs;

use App\Models\KnowledgeDocument;
use App\Services\Knowledge\EmbeddingService;
use App\Services\Knowledge\PdfTextExtractor;
use App\Services\Knowledge\TextChunker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class ProcessKnowledgeDocument implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;

    public function __construct(public int $knowledgeDocumentId) {}

    public function handle(PdfTextExtractor $pdfExtractor, TextChunker $chunker, EmbeddingService $embeddings): void
    {
        $document = KnowledgeDocument::find($this->knowledgeDocumentId);

        if (! $document) {
            return;
        }

        $document->update(['status' => 'processing', 'error_message' => null]);

        try {
            $text = $document->source_type === 'pdf'
                ? $pdfExtractor->extract(Storage::disk('public')->path($document->file_path))
                : (string) $document->raw_text;

            $text = trim($text);

            if ($text === '') {
                throw new RuntimeException('Não foi possível extrair texto deste documento (PDF sem texto embutido ou campo de texto vazio).');
            }

            $chunkTexts = $chunker->chunk(
                $text,
                (int) config('knowledge_ai.chunk_size'),
                (int) config('knowledge_ai.chunk_overlap')
            );

            if (empty($chunkTexts)) {
                throw new RuntimeException('O documento não gerou nenhum trecho válido.');
            }

            $document->chunks()->delete();

            $embeddingsAvailable = $embeddings->isConfigured();
            $vectors = $embeddingsAvailable ? $embeddings->embedMany($chunkTexts) : [];

            foreach ($chunkTexts as $index => $chunkText) {
                $document->chunks()->create([
                    'chunk_index' => $index,
                    'content' => $chunkText,
                    'embedding' => $vectors[$index] ?? null,
                ]);
            }

            $document->update([
                'status' => $embeddingsAvailable ? 'ready' : 'failed',
                'error_message' => $embeddingsAvailable
                    ? null
                    : 'Texto extraído e dividido em '.count($chunkTexts).' trecho(s), mas a chave OPENAI_API_KEY não está configurada — os embeddings não foram gerados. Configure a chave e reprocesse o documento.',
                'chunk_count' => count($chunkTexts),
                'processed_at' => now(),
            ]);
        } catch (Throwable $e) {
            $document->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'processed_at' => now(),
            ]);
        }
    }
}
