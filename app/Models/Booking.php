<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    public $table = 'bookings';
    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'customer_id', 'photographer_id', 'country', 'checkout', 'date', 'time'
    ];

    public function photographer()
    {
    	return $this->belongsTo('App\Models\Photographer', 'photographer_id', 'id');
    }

    public function customer()
    {
    	return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }

}
