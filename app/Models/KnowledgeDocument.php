<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KnowledgeDocument extends Model
{
    use HasFactory;

    // Mesma taxonomia de tipo de solução usada nos artigos da Base de
    // Conhecimento, para manter os documentos de IA organizados da mesma
    // forma (Sistemas, DataCloud, Serviços de TI, Produtos, Geral).
    public const SOLUTION_TYPES = KnowledgeArticle::SOLUTION_TYPES;

    public const SOURCE_TYPES = [
        'pdf' => 'Arquivo PDF',
        'text' => 'Texto colado',
    ];

    public const STATUSES = [
        'pending' => 'Aguardando processamento',
        'processing' => 'Processando',
        'ready' => 'Pronto',
        'failed' => 'Falhou',
    ];

    protected $fillable = [
        'title',
        'solution_type',
        'product_id',
        'source_type',
        'file_path',
        'raw_text',
        'status',
        'error_message',
        'chunk_count',
        'processed_at',
        'is_active',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function chunks(): HasMany
    {
        return $this->hasMany(KnowledgeChunk::class);
    }

    public function scopeReady(Builder $query): Builder
    {
        return $query->where('status', 'ready')->where('is_active', true);
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function solutionTypeLabel(): string
    {
        return self::SOLUTION_TYPES[$this->solution_type] ?? $this->solution_type;
    }
}
