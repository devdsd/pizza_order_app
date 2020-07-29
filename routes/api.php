<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'LoginController@login');
Route::post('/register', 'RegisterController@register');
Route::post('/logout', 'LoginController@logout')->middleware('auth:api');



// Route::post('/login', 'api\AuthController@login');
// Route::post('/register', 'api\AuthController@register');
// Route::post('/logout', 'api\AuthController@logout')->middleware('auth:api');

// List all pizza orders
Route::get('/pizzas', 'PizzaController@index')->middleware('auth:api');

// Route::get('/pizzas', 'PizzaController@index')->middleware(' api');

// Display specified Pizza Order
Route::get('/pizza/{id}', 'PizzaController@show')->middleware('auth:api');

// Create a new Pizza Order
Route::post('/pizza', 'PizzaController@store')->middleware('auth:api');

// Update Pizza Order
Route::put('/pizza', 'PizzaController@store')->middleware('auth:api');

// Delete a Pizza Order
Route::delete('/pizza/{id}', 'PizzaController@destroy')->middleware('auth:api');
