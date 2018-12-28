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
        return User::withTrashed()->get();
    }

    public function add(Request $request)
    {

        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();
        return response()->json($user, 200);
    }

    public function edit(Request $request)
    {
        $id = $request->query('id');
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function destroy(Request $request)
    {
        $id = $request->query('id');

        $user = User::withTrashed()->findOrFail($id);

        $orders = DB::table('orders')
            ->where('orders.responsible_cook_id', $id)
            ->count();


        $meals = DB::table('meals')
            ->where('meals.responsible_waiter_id', $id)
            ->count();

        if($orders != 0 or $meals!=0){
            $user->delete();
        }else{
            $user->forceDelete();
        }

        return response()->json(null, 204);

    }

    public function restoreDestroy($id)
    {
        User::withTrashed()->find($id)->restore();

        return response()->json(null, 204);;
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return new UserResource($user);
    } 
    
    /* 
    public function show($id)
    {
        return User::find($id);
    }

    public function myProfile(Request $request)
    {
        return new UserResource($request->user());
    }
     */
    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->blocked === 1) {
            $user->blocked = 0;
        } else {
            $user->blocked = 1;
        }
        $user->save();
        return response()->json($user, 200);
    }

    public function myProfile(Request $request)
    {
        return new UserResource($request->user());
    }

    /* public function store(Request $request)
    {
        $request->validate([
                'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
                'email' => 'required|email|unique:users,email',
                'age' => 'integer|between:18,75',
                'password' => 'min:3'
            ]);
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();
        return response()->json(new UserResource($user), 201);
    }
 */
    
   /*  public function emailAvailable(Request $request)
    {
        $totalEmail = 1;
        if ($request->has('email') && $request->has('id')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->where('id', '<>', $request->id)->count();
        } else if ($request->has('email')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->count();
        }
        return response()->json($totalEmail == 0);

     } */


    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $filename = $request->file->getClientOriginalName();

            return $request->file->storeAs('public/profiles', $filename);
        }
    }
}
