<?php

namespace App\Services\Knowledge;

use App\Models\KnowledgeChunk;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class KnowledgeAssistant
{
    public function __construct(
        private readonly EmbeddingService $embeddings,
        private readonly VectorSearch $vectorSearch,
    ) {}

    public function isConfigured(): bool
    {
        return $this->embeddings->isConfigured()
            && filled(config('knowledge_ai.anthropic_api_key'))
            && filled(config('knowledge_ai.anthropic_model'));
    }

    /**
     * @return array{answer: string, sources: array<int, array{title: string}>}
     */
    public function ask(string $question, ?string $solutionType = null): array
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException('A IA da Base de Conhecimento ainda não foi configurada.');
        }

        $questionEmbedding = $this->embeddings->embedOne($question);

        $chunks = $this->vectorSearch->topK($questionEmbedding, (int) config('knowledge_ai.top_k'), $solutionType);

        if ($chunks->isEmpty()) {
            return [
                'answer' => 'Ainda não temos documentos suficientes na Base de Conhecimento para responder a essa pergunta. Fale com o nosso suporte.',
                'sources' => [],
            ];
        }

        $context = $chunks
            ->map(fn (KnowledgeChunk $chunk, int $i) => '['.($i + 1).'] '.$chunk->document->title.":\n".$chunk->content)
            ->implode("\n\n---\n\n");

        $systemPrompt = 'Você é o assistente da Base de Conhecimento da Databit. Responda em português, de forma direta e objetiva, '
            .'usando apenas as informações do CONTEXTO abaixo. Se o contexto não tiver a resposta, diga que não encontrou a informação '
            .'e sugira falar com o suporte. Cite os números das fontes usadas, no formato [1], [2] etc.';

        $response = Http::withHeaders([
            'x-api-key' => config('knowledge_ai.anthropic_api_key'),
            'anthropic-version' => '2023-06-01',
        ])
            ->timeout(60)
            ->post('https://api.anthropic.com/v1/messages', [
                'model' => config('knowledge_ai.anthropic_model'),
                'max_tokens' => 1024,
                'system' => $systemPrompt,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "CONTEXTO:\n\n{$context}\n\nPERGUNTA: {$question}",
                    ],
                ],
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Falha ao consultar a IA: '.$response->body());
        }

        $answer = collect($response->json('content', []))
            ->where('type', 'text')
            ->pluck('text')
            ->implode("\n");

        $sources = $chunks
            ->map(fn (KnowledgeChunk $chunk) => ['title' => $chunk->document->title])
            ->unique('title')
            ->values()
            ->all();

        return [
            'answer' => trim($answer) !== '' ? $answer : 'Não foi possível gerar uma resposta no momento.',
            'sources' => $sources,
        ];
    }
}
