<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'url',
        'page_id',
        'parent_id',
        'sort_order',
        'is_external',
        'opens_new_tab',
    ];

    protected $casts = [
        'is_external' => 'boolean',
        'opens_new_tab' => 'boolean',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order');
    }

    public function resolveUrl(): string
    {
        if ($this->page) {
            return route('pages.show', $this->page->slug);
        }

        return $this->url ?? '#';
    }
}
