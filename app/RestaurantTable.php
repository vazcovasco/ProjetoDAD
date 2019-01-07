<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class RestaurantTable extends Model
{
    use softDeletes;
    protected $fillable = [
        'table_number',
       

    ];
    protected $primaryKey = 'table_number';

    protected $dates =[
        'deleted_at',
        'updated_at',
        'created_at',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'table_number';
    }
}
