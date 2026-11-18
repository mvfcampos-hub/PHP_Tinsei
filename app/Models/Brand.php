<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

// Fabricantes/marcas com que a Tinsei trabalha (equipamentos, suprimentos e peças).
class Brand extends Model
{
    protected $fillable = ['name', 'logo', 'url', 'note', 'is_active', 'sort_order'];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
