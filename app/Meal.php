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

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function items()
    {
        return $this->belongsTo(User::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    
    public function invoices()
    {
        return $this->belongsTo("App\Invoices");
    }
}
