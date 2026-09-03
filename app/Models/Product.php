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
        'integracoes' => 'Integrações do DataClassic',
    ];

    // Agrupamento de alto nível usado nas listagens: DataCloud (infraestrutura)
    // é uma oferta de natureza diferente dos sistemas/softwares e por isso é
    // sempre apresentada em seção separada das "Soluções de Sistemas". Serviços
    // de TI e Produtos de informática (hardware) têm páginas próprias e não são
    // modelados como Product — ver ItServiceController e HardwareController.
    public const GROUPS = [
        'sistemas' => 'Soluções de Sistemas',
        'cloud' => 'Cloud & Infraestrutura',
    ];

    private const NON_SYSTEM_CATEGORIES = ['cloud'];

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
        'opens_externally',
        'is_featured',
        'is_cloud_highlight',
        'is_ecosystem_node',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_cloud_highlight' => 'boolean',
        'is_ecosystem_node' => 'boolean',
        'is_active' => 'boolean',
        'opens_externally' => 'boolean',
    ];

    // DataSAC e DataMDFe são produtos com plataforma própria fora do site
    // institucional (datasac.com.br, datamdfe.com.br) — todo link para eles
    // deve abrir o site externo direto, em vez da página interna de detalhe.
    public function resolveUrl(): string
    {
        if ($this->opens_externally && $this->external_url) {
            return $this->external_url;
        }

        return route('products.show', $this->slug);
    }

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

    public function scopeEcosystemNode(Builder $query): Builder
    {
        return $query->where('is_ecosystem_node', true);
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
