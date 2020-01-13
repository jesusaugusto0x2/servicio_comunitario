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

//Authenthication routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'api\AuthController@login');
    Route::post('signup', 'api\AuthController@signup');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'api\AuthController@logout');
        Route::get('user', 'api\AuthController@user');
    });
});

Route::group(['middleware' => 'auth:api'], function () {
    //Camps routes
    Route::group(['prefix' => 'camp'], function () {
        Route::post('store', 'api\CampController@store')->middleware('admin');
        Route::put('edit/{id}', 'api\CampController@edit')->middleware('admin');
        Route::get('get/{id}', 'api\CampController@get');
        Route::get('index', 'api\CampController@index');

        //Payments
        Route::group(['prefix' => 'payment'], function () {
            Route::put('validate/{id}', 'api\CampPaymentController@validatePayment')->middleware('admin');
            Route::post('store', 'api\CampPaymentController@store');
        });
    });

    //Configuration routes
    Route::group(['prefix' => 'config'], function () {
        Route::put('makeAdmin/{user_id}', 'api\ConfigurationController@makeAdmin')->middleware('admin');
        Route::put('blockAllowUser/{user_id}', 'api\ConfigurationController@blockAllowUser')->middleware('admin');

        //Get routes
        Route::group(['prefix' => 'get'], function () {
            Route::get('banks', 'api\ConfigurationController@getBanks');
            Route::get('paymentMethods', 'api\ConfigurationController@getPaymentMethods');
        });
    });

    //Admin routes
    Route::group(['prefix' => 'admin'], function () {
        Route::get('users', 'api\AdminController@getUsers')->middleware('admin');
        Route::get('user/{user_id}', 'api\AdminController@getSpecUser')->middleware('admin');
        Route::put('changePassword/{user_id}', 'api\AdminController@changeUserPass')->middleware('admin');
    });
});

Route::post('testphoto', 'api\CampController@testphoto');
