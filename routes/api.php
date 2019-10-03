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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function() {

    Route::apiResource('users', 'API\UserController');
    Route::apiResource('products', 'API\ProductController');
    Route::apiResource('categories', 'API\CategoryController');
    Route::apiResource('reservations', 'API\ReservationController');
    Route::apiResource('orders', 'API\OrderController');
    Route::post('reservations/{id}/confirm','API\ReservationController@confirmReservation');

});


Route::apiResource('details', 'API\DetailController');

Route::get('category', 'API\ProductController@category');

Route::get('items', 'API\ProductController@items');
Route::get('lastProducts', 'API\ProductController@showNew');
Route::get('search','API\ProductController@search');


Route::get('users/{user}/reservations','API\UserController@showReservations');
Route::get('products/{product}/reservations','API\ProductController@showReservations');

Route::get('profile', 'API\UserController@profile');
Route::put('profile', 'API\UserController@updateProfile');