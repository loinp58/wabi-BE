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

Route::get('sua-xe', 'StoresController@index');
Route::get('sua-xe/chi-tiet/{id}', 'StoresController@show');
Route::get('stores/{id}/ratings', 'RatingsController@index');
Route::post('stores/{id}/ratings', 'RatingsController@store');
Route::post('stores/{id}/ratings/like', 'RatingsController@likeComment');
