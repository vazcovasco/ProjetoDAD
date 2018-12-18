<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

<<<<<<< HEAD

define('YOUR_SERVER_URL', 'http://projetodad.local');
// Check "oauth_clients" table for next 2 values: 
define('CLIENT_ID', '2');
<<<<<<< HEAD
define('CLIENT_SECRET', 'yT4oM2g154iboio2NC9owZ20dReGr7n14A7wC6WS');
=======
define('CLIENT_SECRET', '3UiFGPIFLNTqCfnku81ln5F6KoeSnnPKF2GgqIuf');
>>>>>>> b23c21c17f284442199e45c16166f2c2b6c6fa64

=======
>>>>>>> f8082f0e8ad3f44638721f702755e09cbf4370cf
class LoginControllerAPI extends Controller
{
    public function login(Request $request)
    {
        $http = new \GuzzleHttp\Client;
        $response = $http->post(config('services.passport.login_endpoint'), [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => config('services.passport.client_id'),
                'client_secret' => config('services.passport.client_secret'),
                'username' => $request->email,
                'password' => $request->password,
                'scope' => ''
            ],
            'exceptions' => false,
        ]);
        $errorCode= $response->getStatusCode();
        if ($errorCode=='200') {
            return json_decode((string) $response->getBody(), true);
        } else {
            return $response;
            return response()->json(['msg'=>'User credentials are invalid'], $errorCode);
        }
    }

    public function logout()
    {
        \Auth::guard('api')->user()->token()->revoke();
        \Auth::guard('api')->user()->token()->delete();
        return response()->json(['msg'=>'Token revoked'], 200);
    }
}
