<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;
    protected $table = 'password_reset_tokens';

    protected $primaryKey = 'email';

    // Set incrementing to false since email is a string
    public $incrementing = false;

    protected $fillable = ['email', 'token', 'created_at'];

    public $timestamps = false;

}
