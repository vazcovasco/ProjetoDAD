<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'id',
        'state',
        'meal_id',
        'nif',
        'name',
        'date',
        'total_price',
    ];
    public function meals()
    {
        return $this->hasMany("App\Meals");
    }
}
