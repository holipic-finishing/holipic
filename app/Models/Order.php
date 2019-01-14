<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";

    protected $fillable = 
    [ 'branch_id',
      'photographer_id',
      'customer_id',
      'total_amount',
      'dowload_date',
      'purchase_date',
      'purchase_from',
      'payment_method',
      'status',
      'invoice'
  	];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }

    public function photographer()
    {
        return $this->belongsTo('App\Models\Photographer', 'photographer_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }

}
