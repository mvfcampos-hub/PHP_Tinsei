<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price_monthly',
        'storage_gb',
        'device_limit',
        'retention_days',
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

    public function storageLabel(): string
    {
        return $this->storage_gb >= 1024
            ? rtrim(rtrim(number_format($this->storage_gb / 1024, 1), '0'), '.').' TB'
            : $this->storage_gb.' GB';
    }
}
