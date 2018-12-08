<?php

use Illuminate\Http\Request;

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


Route::get('items', 'ItemControllerAPI@getItems');
Route::get('users', 'UserControllerAPI@getUsers');
Route::post('users', 'UserControllerAPI@add');
Route::put('users', 'UserControllerAPI@edit');
Route::delete('users', 'UserControllerAPI@destroy');
Route::post('users/block/{id}', 'UserControllerAPI@blockUser');

Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');
Route::get('users/{id}', 'UserControllerAPI@show');


Route::get('meals', 'MealControllerAPI@getMeals');



/*
Caso prefiram usar Resource Routes para o user, podem implementar antes as rotas:
NOTA: neste caso, o parâmetro a receber nos métodos do controlador é user e não id

Route::apiResource('users','UserControllerAPI');
Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');
*/
