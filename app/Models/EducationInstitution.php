<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EducationInstitution extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_key',
        'address',
        'city',
        'phone',
        'email',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (EducationInstitution $institution) {
            $institution->name_key = static::normalizeKey($institution->name);
        });
    }

    public static function normalizeKey(string $name): string
    {
        return Str::of($name)->squish()->upper()->toString();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
