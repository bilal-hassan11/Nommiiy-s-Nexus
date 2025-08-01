<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_name',
        'description',
        'remark',
        'domain_binding',
        'mode', // <-- Add 'mode' here
    ];

    protected $casts = [
        'domain_binding' => 'boolean',
    ];
}