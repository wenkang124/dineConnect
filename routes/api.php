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


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::namespace('Auth')->group(function () {
//     Route::get('login', 'LoginController@showLoginForm')->name('login');
//     Route::post('login', 'LoginController@login')->name('login');
//     Route::post('logout', 'LoginController@logout')->name('logout');
// });
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('/login', 'LoginController@login');
    Route::post('/register', 'RegisterController@register');
    Route::post('/password/forgot', 'ForgotPasswordController@forgotPassword');
    Route::post('/password/reset', 'ForgotPasswordController@resetPassword');
});

Route::group(['middleware' => 'auth:sanctum'], function () {


    Route::group(['prefix' => 'user'], function () {
        Route::post('/me', function (Request $request) {
            return $request->user();
        });
    });

    Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
        Route::post('/logout', 'LoginController@logout');
    });
});
