<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'company',
        'description',
        'location',
        'contract_type',
        'contact_email',
        'contact_phone',
        'external_url',
        'published_at',
        'expires_at',
        'is_active',
        'status',
        'submitter_name',
        'submitter_email',
        'submitter_phone',
        'removal_token',
        'removal_requested_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'removal_requested_at' => 'datetime',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where('status', 'approved')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(fn (Builder $q) => $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()));
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public static function generateRemovalToken(): string
    {
        return Str::random(48);
    }
}
