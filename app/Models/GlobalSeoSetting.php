<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalSeoSetting extends Model
{
    use HasFactory;

    protected $table = 'global_seo_settings'; // Explicitly set table name

    protected $fillable = [
        'seo_header',
        'seo_homepage',
    ];
}