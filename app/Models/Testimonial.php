<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name', 'role', 'company', 'city', 'state', 'photo', 'quote', 'video_url',
        'rating', 'is_featured', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderByDesc('is_featured')->orderBy('sort_order');
    }

    public function initials(): string
    {
        return initials($this->client_name);
    }

    public function youtubeId(): ?string
    {
        return youtube_id($this->video_url);
    }
}
