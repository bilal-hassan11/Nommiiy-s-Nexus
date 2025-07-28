<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMSBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'status',
        'title',
        'description',
        'language',
        'index',
        'start_date',
        'end_date',
        'mobile_image',
        'web_image',
        'href',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'index' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}