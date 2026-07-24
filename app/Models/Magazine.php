<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'edition',
        'year',
        'cover_image',
        'pdf_file',
        'external_url',
        'published_at',
    ];

    protected $casts = [
        'year' => 'integer',
        'published_at' => 'date',
    ];
}
