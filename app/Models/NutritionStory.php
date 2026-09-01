<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionStory extends Model
{
    use HasFactory;

    public const AREAS = [
        'Saúde Pública',
        'Hospitais',
        'Alimentação Escolar',
        'Segurança Alimentar e Nutricional',
        'Alimentação Coletiva',
        'Consultórios',
        'Universidades e Pesquisa',
        'Políticas Públicas',
        'Outras áreas de atuação',
    ];

    protected $fillable = [
        'title',
        'slug',
        'area',
        'region',
        'role',
        'summary',
        'body',
        'cover_image',
        'submitter_name',
        'submitter_email',
        'status',
        'is_featured',
        'is_active',
        'sort_order',
        'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where('status', 'published')
            ->where(fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }
}
