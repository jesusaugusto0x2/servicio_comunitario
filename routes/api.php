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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['prefix' => 'auth'], function () {

    Route::post('login', 'api\AuthController@login');
    Route::post('signup', 'api\AuthController@signup');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'api\AuthController@logout');
        Route::get('user', 'api\AuthController@user');

        Route::get('hola', function () {
            return 'Hola';
        })->middleware('admin');
    });
});


