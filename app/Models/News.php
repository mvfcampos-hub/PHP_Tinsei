<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'Institucional' => 'Institucional',
        'Lançamentos' => 'Lançamentos',
        'Equipamentos' => 'Equipamentos',
        'Suprimentos e Peças' => 'Suprimentos e Peças',
        'Sustentabilidade' => 'Sustentabilidade',
        'Na Mídia' => 'Na Mídia',
        'Vídeos' => 'Vídeos',
        'Feiras e Eventos' => 'Feiras e Eventos',
        'Mercado' => 'Mercado',
    ];

    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'cover_image', 'video_url', 'source_name',
        'source_url', 'category', 'is_featured', 'published_at', 'author_id',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function youtubeId(): ?string
    {
        return youtube_id($this->video_url);
    }

    // Capa enviada no painel; sem capa, usa a miniatura do vídeo do YouTube.
    public function coverUrl(): ?string
    {
        if ($this->cover_image) {
            return media_url($this->cover_image);
        }

        return ($id = $this->youtubeId()) ? "https://i.ytimg.com/vi/{$id}/hqdefault.jpg" : null;
    }
}
