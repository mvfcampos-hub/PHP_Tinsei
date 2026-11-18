<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventItem extends Model
{
    use HasFactory;

    public const TYPES = [
        'feira' => 'Feira',
        'evento' => 'Evento',
        'treinamento' => 'Treinamento para revendas',
        'lancamento' => 'Lançamento',
        'webinar' => 'Webinar / Live',
        'visita' => 'Visita técnica',
    ];

    protected $fillable = [
        'title', 'slug', 'type', 'description', 'location', 'starts_at', 'ends_at',
        'cover_image', 'external_url', 'is_featured', 'is_published',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->published()
            ->where(fn (Builder $q) => $q->where('starts_at', '>=', now()->startOfDay())
                ->orWhere('ends_at', '>=', now()->startOfDay()))
            ->orderBy('starts_at');
    }

    public function scopePast(Builder $query): Builder
    {
        return $query->published()
            ->where('starts_at', '<', now()->startOfDay())
            ->where(fn (Builder $q) => $q->whereNull('ends_at')->orWhere('ends_at', '<', now()->startOfDay()))
            ->orderByDesc('starts_at');
    }

    public function typeLabel(): string
    {
        return self::TYPES[$this->type] ?? (string) $this->type;
    }
}
