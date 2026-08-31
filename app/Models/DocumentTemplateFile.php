<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class DocumentTemplateFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_template_id',
        'label',
        'file',
        'sort_order',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(DocumentTemplate::class, 'document_template_id');
    }

    public function getUrlAttribute(): ?string
    {
        return Storage::url($this->file);
    }
}
