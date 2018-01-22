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
	// Customers
  Route::group(['prefix' => 'customers'], function (){
    Route::post('', 'CustomerController@create');
    Route::put('{id}', 'CustomerController@update');
    Route::delete('{id}', 'CustomerController@delete');
    Route::get('', 'CustomerController@search');
  });
	// Users
  Route::group(['prefix' => 'users'], function (){
    Route::post('', 'UserController@create');
    Route::put('{id}', 'UserController@update');
    Route::delete('{id}', 'UserController@delete');
    Route::get('', 'UserController@search');
    Route::get('{id}', 'UserController@getOne');
  });
    // Buildings
  Route::group(['prefix' => 'buildings'], function (){
    Route::get('types', 'BuildingController@getTypes');
    Route::get('', 'BuildingController@search');
    Route::post('', 'BuildingController@create');
    Route::put('{id}', 'BuildingController@update');
    Route::delete('{id}', 'BuildingController@delete');
    Route::get('{id}', 'BuildingController@getOne');
  });
    // Catalog
  Route::group(['prefix' => 'cat'], function(){
  	Route::get('roles', 'RolesController@getAll');
  });

});
