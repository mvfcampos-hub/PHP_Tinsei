<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class LicitacaoDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'licitacao_id',
        'label',
        'file',
        'external_url',
        'sort_order',
    ];

    public function licitacao(): BelongsTo
    {
        return $this->belongsTo(Licitacao::class);
    }

    public function getUrlAttribute(): ?string
    {
        return $this->file ? Storage::url($this->file) : $this->external_url;
    }
}
