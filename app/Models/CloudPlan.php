<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloudPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price_monthly',
        'vcpu',
        'ram_gb',
        'disk_gb',
        'description',
        'is_popular',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'price_monthly' => 'decimal:2',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
