<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ComplianceSubmissionFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'compliance_submission_id',
        'file',
        'original_name',
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(ComplianceSubmission::class, 'compliance_submission_id');
    }

    public function getUrlAttribute(): string
    {
        return Storage::url($this->file);
    }
}
