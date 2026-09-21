<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiscalizacaoProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'code',
        'subject',
        'started_at',
        'status',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'started_at' => 'date',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
