<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoScript extends Model
{
    use HasFactory;

    protected $fillable = [
        'language',
        'merchant',
        'seo_header',
        'seo_homepage',
    ];

    // Optional: Cast attributes if you're storing JSON or other complex types
    // protected $casts = [
    //     'seo_header' => 'string', // Example, though string is default
    // ];
}