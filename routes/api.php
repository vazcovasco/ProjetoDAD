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

Route::middleware('auth:api')->get('/user', 'UserControllerAPI@getUser'); 

Route::post('login', 'AuthControllerAPI@login');
Route::post('register', 'AuthControllerAPI@register');
Route::middleware('auth:api')->post('/logout', 'AuthControllerAPI@logout');

/*-------------------USERS---------------------------*/
Route::get('users', 'UserControllerAPI@getUsers');
Route::post('users', 'UserControllerAPI@add');
Route::put('users/{id}', 'UserControllerAPI@update');
Route::get('users/{id}', 'UserControllerAPI@show');
Route::put('users', 'UserControllerAPI@edit');
Route::post('users/changePassword/{id}', 'UserControllerAPI@changePassword');
Route::post('users/changeShiftActive/{id}', 'UserControllerAPI@changeShiftActive');
Route::post('users/changeLastShiftStart/{id}', 'UserControllerAPI@changeLastShiftStart');
Route::post('users/changeLastShiftEnd/{id}', 'UserControllerAPI@changeLastShiftEnd');

Route::delete('users', 'UserControllerAPI@destroy');
Route::post('users/block/{id}', 'UserControllerAPI@blockUser');
Route::post('users/delete/{id}', 'UserControllerAPI@restoreDestroy');
Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');

/*-------------------PHOTO---------------------------*/
Route::post('upload', 'UserControllerAPI@upload');
Route::post('uploadItemPhoto', 'ItemControllerAPI@upload');

/*-------------------ITEMS---------------------------*/
Route::get('items', 'ItemControllerAPI@getItems');
Route::post('items', 'ItemControllerAPI@add');
Route::put('items', 'ItemControllerAPI@edit');
Route::delete('items', 'ItemControllerAPI@destroy');
Route::post('items/delete/{id}', 'ItemControllerAPI@restoreDestroy');

/*-------------------MEALS---------------------------*/
Route::get('meals', 'MealControllerAPI@getMeals');
Route::post('meals', 'MealControllerAPI@add');
Route::get('meals/{id}', 'MealControllerAPI@showMeal');
Route::get('meals/waiter', 'MealControllerAPI@getMealWaiterPerDay');


//ORDERS
Route::get('orders/{id}', 'OrderControllerAPI@getOrders');
Route::delete('orders/{id}', 'OrderControllerAPI@delete');
Route::post('orders/{id}', 'OrderControllerAPI@setState');
Route::post('orders/{id}', 'OrderControllerAPI@confirmOrder');
Route::post('orders', 'OrderControllerAPI@add');

Route::get('invoices', 'InvoiceControllerAPI@getInvoices');
Route::get('invoices/{id}', 'InvoiceControllerAPI@showInvoice');
Route::put('invoices/{id}', 'InvoiceControllerAPI@editPendingInvoice');



Route::get('restaurant_tables', 'RestaurantTableControllerAPI@getRestaurantTables');
//Route::post('restaurant_tables', 'RestaurantTableControllerAPI@add');

Route::get('/statistics/orders/{user}', 'OrderControllerAPI@getOrdersByDay');

Route::get('/statistics/meals/{user}', 'MealControllerAPI@getMealsByDay');

/*
Caso prefiram usar Resource Routes para o user, podem implementar antes as rotas:
NOTA: neste caso, o parâmetro a receber nos métodos do controlador é user e não id

Route::apiResource('users','UserControllerAPI');
Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');
*/
