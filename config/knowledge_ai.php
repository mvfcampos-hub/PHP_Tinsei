<?php

return [

    // Provedor de embeddings, usado para indexar os documentos (PDF/texto)
    // enviados na Base de Conhecimento e para interpretar as perguntas dos
    // usuários. Requer uma chave da OpenAI.
    'openai_api_key' => env('OPENAI_API_KEY'),
    'embedding_model' => env('KB_EMBEDDING_MODEL', 'text-embedding-3-small'),

    // Provedor usado para gerar a resposta final a partir dos trechos
    // recuperados. Requer uma chave da Anthropic e o nome exato do modelo
    // disponível na conta (ex.: um dos modelos Claude atuais).
    'anthropic_api_key' => env('ANTHROPIC_API_KEY'),
    'anthropic_model' => env('ANTHROPIC_MODEL'),

    // Tamanho (em caracteres) de cada trecho indexado e sobreposição entre
    // trechos consecutivos, para não cortar frases importantes ao meio.
    'chunk_size' => (int) env('KB_CHUNK_SIZE', 1200),
    'chunk_overlap' => (int) env('KB_CHUNK_OVERLAP', 150),

    // Quantos trechos mais relevantes são enviados ao modelo para compor
    // cada resposta.
    'top_k' => (int) env('KB_TOP_K', 5),

];
