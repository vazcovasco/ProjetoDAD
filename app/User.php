<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Authenticatable;



class User extends Model
{
    use HasApiTokens, Authenticatable, softDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name', 
        'username',
        'email',
        'password',
        'email_verified_at',
        'type',
        'blocked',
        'photo_url',
        'last_shift_start',
        'last_shift_end',
        'shift_active',



    ];

    protected $dates =[
        'deleted_at',
        'created_at',
        'updated_at',



    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];   
}


