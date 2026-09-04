<?php

namespace App\Services\Knowledge;

use App\Models\KnowledgeChunk;
use Illuminate\Support\Collection;

class VectorSearch
{
    /**
     * Busca os $k trechos mais similares à pergunta, por similaridade de
     * cosseno em memória. Sem um vector store dedicado, isso é feito
     * comparando contra todos os trechos prontos — adequado para o volume
     * de documentos previsto nesta primeira versão da Base de Conhecimento
     * com IA; caso a base cresça muito, este é o ponto a substituir por uma
     * busca vetorial no banco.
     *
     * @param  array<int, float>  $queryEmbedding
     * @return Collection<int, KnowledgeChunk>
     */
    public function topK(array $queryEmbedding, int $k, ?string $solutionType = null): Collection
    {
        $chunks = KnowledgeChunk::query()
            ->whereNotNull('embedding')
            ->whereHas('document', function ($query) use ($solutionType) {
                $query->ready();
                if ($solutionType) {
                    $query->where('solution_type', $solutionType);
                }
            })
            ->with('document')
            ->get();

        return $chunks
            ->map(fn (KnowledgeChunk $chunk) => [
                'chunk' => $chunk,
                'score' => $this->cosineSimilarity($queryEmbedding, $chunk->embedding ?? []),
            ])
            ->sortByDesc('score')
            ->take($k)
            ->pluck('chunk')
            ->values();
    }

    /**
     * @param  array<int, float>  $a
     * @param  array<int, float>  $b
     */
    private function cosineSimilarity(array $a, array $b): float
    {
        if (empty($a) || empty($b) || count($a) !== count($b)) {
            return -1.0;
        }

        $dot = 0.0;
        $normA = 0.0;
        $normB = 0.0;

        foreach ($a as $i => $valueA) {
            $valueB = $b[$i];
            $dot += $valueA * $valueB;
            $normA += $valueA * $valueA;
            $normB += $valueB * $valueB;
        }

        if ($normA <= 0 || $normB <= 0) {
            return -1.0;
        }

        return $dot / (sqrt($normA) * sqrt($normB));
    }
}
