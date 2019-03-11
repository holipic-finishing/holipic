<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Eloquent as Model;

class Timezone extends Model
{
    public $table = 'timezones';

    public $fillable = [
        'country_code', 'country_name', 'zone_name', 'gmt_offset', 'timestamp'
    ];
}
