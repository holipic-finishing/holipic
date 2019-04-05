<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $table = 'rooms';

    public $fillable = [
        'room_number', 'room_hash', 'added_date', 'updated_date'
    ];

    public $timestamps = false;

    public function listings(){
        return $this->hasMany('App\Models\Listing','room_id','id');
    }

    public function customer(){
        return $this->hasOne('App\Models\Customer','room_id','id');
    }
}
