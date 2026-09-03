<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KnowledgeArticle extends Model
{
    use HasFactory;

    // Tipo de solução: agrupamento de alto nível da Base de Conhecimento,
    // espelhando as áreas de negócio do site (Sistemas, DataCloud, Serviços
    // de TI, Produtos de informática), mais "Geral" para dúvidas de conta e
    // primeiros passos que não pertencem a uma área específica.
    public const SOLUTION_TYPES = [
        'geral' => 'Geral / Primeiros Passos',
        'sistemas' => 'Sistemas',
        'cloud' => 'DataCloud',
        'servicos-ti' => 'Serviços de TI',
        'hardware' => 'Produtos de Informática',
    ];

    protected $fillable = [
        'title',
        'slug',
        'solution_type',
        'product_id',
        'excerpt',
        'content',
        'video_url',
        'cover_image',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeSolutionType(Builder $query, string $type): Builder
    {
        return $query->where('solution_type', $type);
    }

    public function solutionTypeLabel(): string
    {
        return self::SOLUTION_TYPES[$this->solution_type] ?? $this->solution_type;
    }

    // Converte URLs de assistir do YouTube/Vimeo para o formato de embed,
    // para que o vídeo possa ser exibido diretamente na página do artigo.
    public function videoEmbedUrl(): ?string
    {
        if (! $this->video_url) {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]+)/', $this->video_url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        if (preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $matches)) {
            return 'https://player.vimeo.com/video/'.$matches[1];
        }

        return $this->video_url;
    }
}
