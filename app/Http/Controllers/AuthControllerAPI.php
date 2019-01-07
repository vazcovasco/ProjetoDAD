<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Http\Resources\User as UserResource;

class AuthControllerAPI extends Controller
{
    public function login(Request $request)
    {

        $user = User::where($request->loginByUsername ? 'username' : 'email', $request->credential)->first();

        if(!$user)
        {
            return response()->json(['error: No user found'], 422);
        }

        $http = new \GuzzleHttp\Client;

        try {
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $user->email,
                    'password' => $request->password,
                ]
            ]);
            return $response->getBody();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter an email or a password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }
            return response()->json('Something went wrong on the server.', $e->getCode());
        }
    }

    public function register(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:3'
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'photo_url' => $request->photo_url,
            'type' => $request->type
        ]);
        
        Mail::send('mail.activation', ['user' => $user], function($message) use ($user) {
            $message->to($user['email']);
            $message->subject('Projeto DAD - Account Activation');
        });

        return new UserResource($user); 
    }

    public function logout()
    {
        auth()->user()->tokens->each(function($token, $key) {
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }
}
