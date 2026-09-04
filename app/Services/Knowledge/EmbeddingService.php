<?php

namespace App\Services\Knowledge;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class EmbeddingService
{
    public function isConfigured(): bool
    {
        return filled(config('knowledge_ai.openai_api_key'));
    }

    /**
     * @param  array<int, string>  $texts
     * @return array<int, array<int, float>>
     */
    public function embedMany(array $texts): array
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException('OPENAI_API_KEY não configurada — defina a chave para habilitar o processamento de IA.');
        }

        $response = Http::withToken(config('knowledge_ai.openai_api_key'))
            ->timeout(60)
            ->post('https://api.openai.com/v1/embeddings', [
                'model' => config('knowledge_ai.embedding_model'),
                'input' => $texts,
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Falha ao gerar embeddings: '.$response->body());
        }

        $data = $response->json('data', []);

        // A API retorna os embeddings na mesma ordem dos textos enviados,
        // mas reordenamos explicitamente por "index" por segurança.
        usort($data, fn ($a, $b) => $a['index'] <=> $b['index']);

        return array_map(fn ($item) => $item['embedding'], $data);
    }

    /**
     * @return array<int, float>
     */
    public function embedOne(string $text): array
    {
        return $this->embedMany([$text])[0] ?? [];
    }
}
