<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

// Linhas do portfólio (Equipamentos Novos, Recon, Suprimentos, Peças). O
// catálogo completo de itens vive na loja B2B (loja.tinsei.com.br); aqui
// ficam a apresentação de cada linha e o link para ela na loja.
class PortfolioCategory extends Model
{
    public const ICONS = [
        'printer' => 'Impressora',
        'recycle' => 'Recondicionado',
        'droplet' => 'Suprimentos',
        'cog' => 'Peças',
        'box' => 'Caixa',
    ];

    protected $fillable = [
        'name', 'slug', 'tagline', 'description', 'icon', 'image', 'highlights',
        'item_count_label', 'store_url', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'highlights' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function storeUrl(): string
    {
        return $this->store_url ?: SiteSetting::get('store_url');
    }
}
