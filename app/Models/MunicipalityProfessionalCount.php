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
        'nutritionists_count',
        'technicians_count',
        'legal_entities_count',
        'total_count',
        'reference_date',
    ];

    protected $casts = [
        'nutritionists_count' => 'integer',
        'technicians_count' => 'integer',
        'legal_entities_count' => 'integer',
        'total_count' => 'integer',
        'reference_date' => 'date',
    ];
}
