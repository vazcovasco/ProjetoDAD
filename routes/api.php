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
Route::put('users/{id}', 'UserControllerAPI@edit');
Route::delete('users/{id}', 'UserControllerAPI@delete');
Route::middleware('auth:api')->get('users/me', 'UserControllerAPI@myProfile');
Route::get('users/{id}', 'UserControllerAPI@show');
Route::post('users', 'UserControllerAPI@uploadImage');

Route::get('orders', 'OrderControllerAPI@getOrders');
Route::delete('orders/{id}', 'OrderControllerAPI@delete');


Route::get('meals', 'MealControllerAPI@getMeals');



/*
Caso prefiram usar Resource Routes para o user, podem implementar antes as rotas:
NOTA: neste caso, o parâmetro a receber nos métodos do controlador é user e não id

Route::apiResource('users','UserControllerAPI');
Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');
*/
