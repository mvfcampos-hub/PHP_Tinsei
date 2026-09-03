<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class News extends Model
{
    use HasFactory;

    // "Notícias" cobre tanto novidades/lançamentos da Databit quanto artigos
    // de interesse selecionados para divulgação (mercado de TI, segurança,
    // reforma tributária) — por isso as categorias vão além de conteúdo
    // institucional.
    public const CATEGORIES = [
        'Lançamento' => 'Lançamento de produto',
        'Novidade' => 'Novidade',
        'Institucional' => 'Institucional',
        'Cloud' => 'Cloud',
        'Mobile' => 'Mobile',
        'Parcerias' => 'Parcerias',
        'Reforma Tributária' => 'Reforma Tributária',
        'Segurança da Informação' => 'Segurança da Informação',
        'Mercado de TI' => 'Mercado de TI',
    ];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'category',
        'is_featured',
        'published_at',
        'author_id',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
