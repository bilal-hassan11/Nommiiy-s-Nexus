<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';

    protected $fillable = [
        'merchant_id',
        'content_type', // NEW: Added content_type
        'status',
        'title',
        'description',
        'language',
        'index',
        'start_date',
        'end_date',
        'mobile_image',
        'web_image',
        // 'href' is removed as it's not in the latest Vue template
    ];

    protected $casts = [
        'index' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}