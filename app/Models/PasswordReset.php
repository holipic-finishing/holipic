<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    public $table = "password_resets";

    public $fillable = ['email', 'token', 'life_time'];
}
