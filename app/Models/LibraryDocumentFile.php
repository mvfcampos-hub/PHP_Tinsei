<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class LibraryDocumentFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'library_document_id',
        'label',
        'file',
        'external_url',
        'sort_order',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(LibraryDocument::class, 'library_document_id');
    }

    public function getUrlAttribute(): ?string
    {
        return $this->file ? Storage::url($this->file) : $this->external_url;
    }
}
