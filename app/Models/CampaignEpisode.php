<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignEpisode extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'title',
        'youtube_url',
        'sort_order',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function getEmbedUrlAttribute(): string
    {
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{6,})/', $this->youtube_url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        return $this->youtube_url;
    }
}
