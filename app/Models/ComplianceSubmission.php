<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ComplianceSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'protocol',
        'nutritionist_name',
        'crn_number',
        'inspection_reference',
        'notes',
        'status',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'protocol';
    }

    public function files(): HasMany
    {
        return $this->hasMany(ComplianceSubmissionFile::class);
    }

    public static function generateProtocol(): string
    {
        do {
            $protocol = 'ADQ-'.now()->format('Y').'-'.Str::upper(Str::random(6));
        } while (self::where('protocol', $protocol)->exists());

        return $protocol;
    }
}
