<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use Notifiable;
    protected $fillable = [
        'id',
        'state',
        'item_id',
        'meal_id',
        'responsible_cook_id',
        'start',
        'end',
        'created_at',
        'updated_at',
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
