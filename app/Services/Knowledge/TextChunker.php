<?php

namespace App\Services\Knowledge;

class TextChunker
{
    /**
     * Divide um texto longo em trechos de até $chunkSize caracteres, com
     * $overlap caracteres de sobreposição entre trechos consecutivos (para
     * não perder contexto que atravesse a fronteira de um trecho). Evita
     * cortar no meio de uma palavra sempre que possível.
     *
     * @return array<int, string>
     */
    public function chunk(string $text, int $chunkSize, int $overlap): array
    {
        $text = trim(preg_replace('/\s+/', ' ', $text) ?? '');

        if ($text === '') {
            return [];
        }

        $chunks = [];
        $length = mb_strlen($text);
        $start = 0;

        while ($start < $length) {
            $end = min($start + $chunkSize, $length);

            if ($end < $length) {
                $window = mb_substr($text, $start, $end - $start);
                $lastSpace = mb_strrpos($window, ' ');
                if ($lastSpace !== false && $lastSpace > 0) {
                    $end = $start + $lastSpace;
                }
            }

            $chunk = trim(mb_substr($text, $start, $end - $start));
            if ($chunk !== '') {
                $chunks[] = $chunk;
            }

            if ($end >= $length) {
                break;
            }

            $start = max($end - $overlap, $start + 1);
        }

        return $chunks;
    }
}
