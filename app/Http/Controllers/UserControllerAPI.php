<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;


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
/*        $user->name = $request->name; 
 */        $user->id = null;
        $user->email_verified_at = null;
        $user->blocked = 0;
        $user->photo_url=null;
        $user->last_shift_start =null;
        $user->last_shift_end =null;
        $user->shift_active =0;
        $user->deleted_at=null;
        $user->created_at=null;
        $user->updated_at=null;
        $user->fill($request->all()); 
        $user->password = Hash::make($user->password);
       $user->save(); 
       return response()->json($user,200);
    } 
    public function edit(Request $request)
    {
        $id = $request->query('id');
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user,200);
    }
    public function destroy(Request $request)
    {
        $id = $request->query('id');
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
    public function show($id)
    {
        return User::find($id);
    }

    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->blocked === 1) {
            $user->blocked = 0;
        } else {
            $user->blocked = 1;
        }
        $user->save();
        return response()->json($user,200);
    }

        /*Caso não se pretenda fazer uso de Eloquent API Resources (https://laravel.com/docs/5.5/eloquent-resources), é possível implementar com esta abordagem:
        if ($request->has('page')) {
            return User::with('department')->paginate(5);;
        } else {
            return User::with('department')->get();;
        }*/
    

    /* public function show($id)
    {
        return new UserResource(User::find($id));
    }

    public function store(Request $request)
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

    public function update(Request $request, $id)
    {
        $request->validate([
                'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
                'email' => 'required|email|unique:users,email,'.$id,
                'age' => 'integer|between:18,75'
            ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
        return new UserResource($user);
    }
    public function emailAvailable(Request $request)
    {
        $totalEmail = 1;
        if ($request->has('email') && $request->has('id')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->where('id', '<>', $request->id)->count();
        } else if ($request->has('email')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->count();
        }
        return response()->json($totalEmail == 0);
    } */
}
