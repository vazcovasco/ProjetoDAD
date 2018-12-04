<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' =>$this->id,
        'name'=>$this->name, 
        'username'=>$this->username,
        'email'=>$this->email,
        'email_verified_at'=>$this->email_verified_at,
        'password'=>$this->password,
        'type'=>$this->type,
        'blocked'=>$this->blocked,
        'photo_url'=>$this->photo_url,
        'last_shift_start'=>$this->last_shift_start,
        'last_shift_end'=>$this->last_shift_end,
        'shift_active'=>$this->shift_active,
        'deleted_at' =>$this->delete_at,
        'remember_token'=>$this->remember_token,
        'created_at'=>$this->created_at,
        'updated_at'=>$this->updated_at,
        ];
    }
}
