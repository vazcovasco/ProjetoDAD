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

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
