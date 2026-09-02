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

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }
}
