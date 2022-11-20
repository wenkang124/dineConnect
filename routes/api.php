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


Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('/login', 'LoginController@login');
    Route::post('/register', 'RegisterController@register');
    Route::post('/password/forgot', 'ForgotPasswordController@forgotPassword');
    Route::post('/password/reset', 'ForgotPasswordController@resetPassword');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('/me', 'UserController@me');
        Route::post('/update', 'UserController@update');
        Route::post('/update_passcode', 'UserController@updatePasscode');
        Route::post('/logout', 'UserController@logout');
        Route::delete('/delete', 'UserController@delete');
    });

    Route::group(['prefix' => 'home'], function () {
        Route::get('', 'HomeController@getAllHomeData');
    });


    Route::group(['prefix' => 'preferences'], function () {
        Route::get('', 'PreferenceController@getAllList');
        Route::post('/submit', 'PreferenceController@submit');
    });
});
