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
    Route::post('/register-resend-otp', 'RegisterController@registerResendOtp');
    Route::post('/register-verify-otp', 'RegisterController@registerVerifyOtp');
    Route::post('/password/forgot', 'ForgotPasswordController@forgotPassword');
    Route::post('/password/reset', 'ForgotPasswordController@resetPassword');
});

Route::group(['prefix' => 'config'], function () {
    Route::get('/countries', 'ConfigController@countries');
    Route::get('/occupations', 'ConfigController@occupations');
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::group(['prefix' => 'config'], function () {
        Route::get('/filter-options', 'ConfigController@filterOptions');
        Route::get('/moods', 'ConfigController@moods');
        Route::get('/categories', 'ConfigController@categories');
    });


    Route::group(['prefix' => 'user'], function () {
        Route::get('/me', 'UserController@me');
        Route::post('/update', 'UserController@update');
        Route::post('/update-passcode', 'UserController@updatePasscode');
        Route::post('/logout', 'UserController@logout');
        Route::delete('/delete', 'UserController@delete');
        Route::get('/favourites', 'UserController@favourites');
        Route::post('/favourite', 'UserController@favourite');
        Route::post('/feedback', 'UserController@feedback');
    });

    Route::group(['prefix' => 'preferences'], function () {
        Route::get('', 'PreferenceController@getAllList');
        Route::post('/submit', 'PreferenceController@submit');
    });

    Route::group(['prefix' => 'home'], function () {
        Route::get('', 'HomeController@getAllHomeData');
    });

    Route::group(['prefix' => 'merchant'], function () {
        Route::get('', 'MerchantController@getMerchantList');
        Route::get('/random-list', 'MerchantController@randomList');
        Route::get('/detail/{id}', 'MerchantController@detail')->name('api.merchant.detail');
        Route::post('/favourite/{id}', 'MerchantController@favourite');
        Route::get('/{id}/dishes', 'MerchantController@dishes');
        Route::get('/{id}/galleries', 'MerchantController@galleries');
        Route::get('/{id}/ads', 'MerchantController@ads');
        Route::get('/{id}/reviews', 'MerchantController@reviews');
    });

    Route::group(['prefix' => 'notification'], function () {
        Route::get('/', 'NotificationController@getAllList');
        Route::get('/detail/{id}', 'NotificationController@detail');
    });

    Route::group(['prefix' => 'annoucement'], function () {
        Route::get('/', 'AnnoucementController@getAllList');
        Route::get('/detail/{id}', 'AnnoucementController@detail');
    });

    Route::group(['prefix' => 'search'], function () {
        Route::post('/', 'SearchController@search');
        Route::post('/filter', 'SearchController@filter');
        Route::get('/histories', 'SearchController@histories');
        Route::get('/suggestion-by-lat-lng', 'SearchController@suggestionByLatLng');
        Route::delete('/histories/delete/{ids}', 'SearchController@historiesDelete');
    });

    Route::group(['prefix' => 'dishes'], function () {
        Route::get('/', 'DishController@getAllList');
        Route::get('/{sub_category_id}/merchant_id/{merchant_id?}/merchant_menu_category_id/{merchant_menu_category_id?}', 'DishController@getAllListBySubCategoryId');
        Route::get('/detail/{id}', 'DishController@detail')->name('api.dishes.detail');
        Route::get('/menu-categories/{merchant_id}', 'DishController@menuCategories');
        Route::get('/sub-categories/{menu_category_id}', 'DishController@subCategories');
    });

    Route::group(['prefix' => 'advertisment'], function () {
        Route::get('/', 'AdvertismentController@getAllList');
        Route::get('/detail/{id}', 'AdvertismentController@detail');
    });

    Route::group(['prefix' => 'review'], function () {
        Route::post('/', 'ReviewController@store');
        Route::get('/detail/{id}', 'ReviewController@detail');
        Route::post('comment', 'ReviewController@comment');
        Route::post('like', 'ReviewController@like');
    });

    Route::group(['prefix' => 'report'], function () {
        Route::post('/', 'ReportController@store');
        Route::get('/reason', 'ReportController@getReportReason');
    });
});
