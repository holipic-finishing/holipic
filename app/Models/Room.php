<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $table = 'rooms';

    public $fillable = [
        'room_number', 'room_hash'
    ];

    public $timestamps = false;
}
