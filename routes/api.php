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

Route::post('/register', 'api\AuthController@register');
Route::post('/login', 'api\AuthController@login');

// List all pizza orders
Route::get('/pizzas', 'PizzaController@index')->middleware(' api');

// Display specified Pizza Order
Route::get('/pizza/{id}', 'PizzaController@show');

// Create a new Pizza Order
Route::post('/pizza', 'PizzaController@store');

// Update Pizza Order
Route::put('/pizza', 'PizzaController@store');

// Delete a Pizza Order
Route::delete('/pizza/{id}', 'PizzaController@destroy');
