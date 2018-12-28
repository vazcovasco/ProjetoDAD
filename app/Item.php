<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Item extends Model
{
    use softDeletes;
    protected $fillable = [
        'id',
        'name',
        'type',
        'description',
        'photo_url',
        'price',
    ];

    protected $dates =[
        'deleted_at',
        'created_at',
        'updated_at',



    ];

}
