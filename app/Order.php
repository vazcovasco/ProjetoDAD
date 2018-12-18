<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use Notifiable;
    protected $fillable = [
        'state',
    ];

    public function meals()
    {
        return $this->belongsTo(Meal::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function items()
    {
        return $this->belongsTo(Item::class);
    }
}
