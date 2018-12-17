<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserControllerAPI;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//AUTH
Route::post('login', 'LoginControllerAPI@login')->name('login');

Route::get('items', 'ItemControllerAPI@getItems');
Route::get('users', 'UserControllerAPI@getUsers');
Route::post('users', 'UserControllerAPI@add');
Route::put('users/{id}', 'UserControllerAPI@update');
Route::delete('users/{id}', 'UserControllerAPI@delete');
Route::get('users/{id}', 'UserControllerAPI@show');
Route::post('upload', 'UserControllerAPI@upload');
Route::middleware('auth:api')->get('users/me', 'UserControllerAPI@myProfile');
Route::put('users', 'UserControllerAPI@edit');



Route::delete('users', 'UserControllerAPI@destroy');
Route::post('users/block/{id}', 'UserControllerAPI@blockUser');
<<<<<<< HEAD
Route::post('users/delete/{id}', 'UserControllerAPI@restoreDestroy');
=======
Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');
<<<<<<< HEAD
>>>>>>> f8082f0e8ad3f44638721f702755e09cbf4370cf
=======
>>>>>>> f8082f0e8ad3f44638721f702755e09cbf4370cf


Route::post('items', 'ItemControllerAPI@add');
Route::put('items', 'ItemControllerAPI@edit');
Route::delete('items', 'ItemControllerAPI@destroy');


Route::get('meals', 'MealControllerAPI@getMeals');
Route::post('users', 'UserControllerAPI@uploadImage');



/*
Caso prefiram usar Resource Routes para o user, podem implementar antes as rotas:
NOTA: neste caso, o parâmetro a receber nos métodos do controlador é user e não id

Route::apiResource('users','UserControllerAPI');
Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');
*/
