<?php

// app/Models/Transaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjustments extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'name',
        'affiliate',
        'currency',
        'transaction_type',
        'created_at',
        'completed_at',
        'time_zone',
        'player_id',
    ];

    // Optionally, for better currency handling, consider casting it as a JSON array
    protected $casts = [
        'currency' => 'array', // If you adapt the database to JSON
    ];
}
