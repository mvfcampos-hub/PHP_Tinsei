<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MunicipalityProfessionalCount extends Model
{
    use HasFactory;

    protected $table = 'municipality_professional_counts';

    protected $fillable = [
        'municipality',
        'state',
        'category',
        'professionals_count',
        'reference_date',
    ];

    protected $casts = [
        'professionals_count' => 'integer',
        'reference_date' => 'date',
    ];
}
