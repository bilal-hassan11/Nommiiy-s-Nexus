<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliatePopUpBanner extends Model
{
    use HasFactory;

    protected $table = 'affiliate_pop_up_banners';

    protected $fillable = [
        'merchant_id',
        'status',
        'language',
        'title',
        'description',
        'link',
        'link_target',
        'start_date',
        'end_date',
        'mobile_image_path',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}