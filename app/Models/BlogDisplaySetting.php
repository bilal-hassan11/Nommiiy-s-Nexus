<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogDisplaySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant',
        'currency',
        'display_on_top', // Match the database column name
    ];
}