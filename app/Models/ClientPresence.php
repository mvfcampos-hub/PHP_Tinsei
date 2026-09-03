<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPresence extends Model
{
    use HasFactory;

    public const TYPE_STATE = 'state';

    public const TYPE_COUNTRY = 'country';

    protected $fillable = [
        'region_type',
        'code',
        'name',
        'device_count',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'device_count' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->where('region_type', $type);
    }
}
