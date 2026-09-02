<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventItem extends Model
{
    use HasFactory;

    public const TYPES = [
        'evento' => 'Evento',
        'lancamento' => 'Lançamento de Produto',
        'webinar' => 'Webinar',
        'treinamento' => 'Treinamento',
    ];

    protected $fillable = [
        'title',
        'slug',
        'type',
        'description',
        'location',
        'starts_at',
        'ends_at',
        'cover_image',
        'external_url',
        'product_id',
        'is_featured',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('starts_at', '>=', now()->startOfDay())->orderBy('starts_at');
    }

    public function typeLabel(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
