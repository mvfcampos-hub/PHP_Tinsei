<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    public const PLACEMENTS = [
        'home_hero' => 'Destaque principal (topo da home)',
        'home_notice' => 'Faixa de aviso (topo de todas as páginas)',
        'home_campaign' => 'Campanha (meio da home)',
    ];

    protected $fillable = [
        'title', 'subtitle', 'eyebrow', 'image', 'link_url', 'link_label', 'placement',
        'starts_at', 'ends_at', 'sort_order', 'is_active', 'overlay_title',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
        'overlay_title' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(fn (Builder $q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn (Builder $q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', now()))
            ->orderBy('sort_order');
    }

    public function scopePlacement(Builder $query, string $placement): Builder
    {
        return $query->where('placement', $placement);
    }

    public function imageUrl(): ?string
    {
        return media_url($this->image);
    }
}
