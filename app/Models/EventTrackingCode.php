<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTrackingCode extends Model
{
    use HasFactory;

    protected $table = 'event_tracking_codes';

    protected $fillable = [
        'merchant',
        'platform',
        'currency',
        'tracker',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'platform' => 'array', // Cast JSON column to array
        'tracker' => 'array',  // Cast JSON column to array
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}