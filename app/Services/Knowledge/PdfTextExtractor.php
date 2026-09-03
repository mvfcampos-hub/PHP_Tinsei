<?php

namespace App\Services\Knowledge;

use Smalot\PdfParser\Parser;

class PdfTextExtractor
{
    /**
     * Extrai o texto de um PDF a partir do caminho absoluto do arquivo.
     * Extrai apenas texto embutido no PDF — páginas escaneadas como imagem
     * (sem OCR) não são lidas nesta primeira versão.
     */
    public function extract(string $absolutePath): string
    {
        $parser = new Parser;
        $pdf = $parser->parseFile($absolutePath);

        $text = $pdf->getText();

        return trim($text);
    }
}
