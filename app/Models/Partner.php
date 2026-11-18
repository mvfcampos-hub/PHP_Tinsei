<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

// Sócios / liderança da Tinsei.
class Partner extends Model
{
    protected $fillable = [
        'name', 'role', 'since_label', 'photo', 'summary', 'bio', 'quote', 'highlights',
        'linkedin_url', 'instagram_url', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'highlights' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function initials(): string
    {
        return initials($this->name);
    }
}
