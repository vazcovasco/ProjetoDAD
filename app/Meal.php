<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Meal extends Model
{


    protected $fillable = [
        'id',
        'state',
        'table_number',
        'start',
        'end',
        'responsible_waiter_id',
        'total_price_preview',
    ];



}
