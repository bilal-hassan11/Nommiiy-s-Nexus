<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogType extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_type',
        'priority',
        'locales',
    ];

    protected $casts = [
        'locales' => 'array', // Cast to array for JSON serialization/deserialization
    ];
}