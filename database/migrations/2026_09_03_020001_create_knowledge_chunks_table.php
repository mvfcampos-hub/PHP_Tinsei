<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('knowledge_chunks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knowledge_document_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('chunk_index');
            $table->longText('content');
            // Vetor de embedding serializado como JSON (array de floats).
            // Sem extensão de banco vetorial disponível no ambiente atual,
            // a busca por similaridade é feita em memória (ver VectorSearch)
            // — adequado para o volume de documentos previsto nesta primeira
            // versão; se a base crescer muito, migrar para um vector store
            // dedicado.
            $table->longText('embedding')->nullable();
            $table->timestamps();

            $table->unique(['knowledge_document_id', 'chunk_index']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_chunks');
    }
};
