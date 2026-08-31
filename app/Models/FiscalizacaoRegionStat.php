<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiscalizacaoRegionStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'region',
        'visits_count',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'visits_count' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
