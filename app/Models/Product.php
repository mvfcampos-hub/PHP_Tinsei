<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'gestao' => 'Gestão Empresarial (ERP)',
        'cloud' => 'Cloud & Infraestrutura',
        'mobile' => 'Mobilidade',
        'atendimento' => 'Atendimento ao Cliente',
        'fiscal' => 'Documentos Fiscais',
        'crm' => 'Relacionamento & Vendas (CRM)',
        'comunicacao' => 'Comunicação',
        'ti' => 'Serviços de TI',
    ];

    // Agrupamento de alto nível usado nas listagens: DataCloud (infraestrutura)
    // e Serviços de TI são ofertas de natureza diferente dos sistemas/softwares
    // e por isso são sempre apresentados em seções separadas das "Soluções de
    // Sistemas" (ERP, mobilidade, atendimento, fiscal, CRM e comunicação).
    public const GROUPS = [
        'sistemas' => 'Soluções de Sistemas',
        'cloud' => 'Cloud & Infraestrutura',
        'ti' => 'Serviços de TI',
    ];

    private const NON_SYSTEM_CATEGORIES = ['cloud', 'ti'];

    protected $fillable = [
        'name',
        'slug',
        'category',
        'tagline',
        'summary',
        'description',
        'icon',
        'cover_image',
        'external_url',
        'is_featured',
        'is_cloud_highlight',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_cloud_highlight' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(EventItem::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function scopeSystems(Builder $query): Builder
    {
        return $query->whereNotIn('category', self::NON_SYSTEM_CATEGORIES);
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    public function group(): string
    {
        return in_array($this->category, self::NON_SYSTEM_CATEGORIES, true) ? $this->category : 'sistemas';
    }

    public function groupLabel(): string
    {
        return self::GROUPS[$this->group()] ?? $this->group();
    }

    public function isSystem(): bool
    {
        return $this->group() === 'sistemas';
    }
}
