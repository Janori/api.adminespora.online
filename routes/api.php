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
Route::get('test', 'TestController@test');
Route::post('auth', 'AuthController@authenticate');

Route::group(['middleware'=>['jwt.auth']], function () {
  Route::group(['prefix' => 'customers'], function (){
    Route::post('', 'CustomerController@create');
    Route::put('{id}', 'CustomerController@update');
    Route::delete('{id}', 'CustomerController@delete');
    Route::get('', 'CustomerController@search');
  });
});
