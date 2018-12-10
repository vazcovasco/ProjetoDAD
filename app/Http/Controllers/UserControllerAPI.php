<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use App\Http\Resources\User as UserResource;

use Illuminate\Support\Facades\DB;

use App\User;
use App\StoreUserRequest;
use Hash;


class UserControllerAPI extends Controller
{
    public function getUsers(Request $request)
    {
        return User::all();
    }

    public function add(Request $request)
    {
        $user = new User();
        $user->id = null;
        $user->email_verified_at = null;
        $user->blocked = 0;
        $user->photo_url = null;
        $user->last_shift_start = null;
        $user->last_shift_end = null;
        $user->shift_active = 0;
        $user->deleted_at = null;
        $user->created_at = null;
        $user->updated_at = null;
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();
        return response()->json($user, 200);


    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return $user;
    }

    public function delete($id)
    {
      return User::destroy($id);
    }

    public function show($id)
    {
        return User::find($id);
    }

    public function myProfile(Request $request)
    {
        return new UserResource($request->user());
    }
}
