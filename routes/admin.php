<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', function () {
    return redirect()->route('admin.home');
});

Route::namespace('Auth')->group(function () {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login');
    Route::post('logout', 'LoginController@logout')->name('logout');
});


Route::middleware('auth:admin')->group(function () {
    Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::get('/datatable', [App\Http\Controllers\Admin\UserController::class, 'dataTable'])->name('datatable');
        Route::get('/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        Route::get('/edit/{item}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
        Route::post('/update/{item}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
        Route::post('/delete/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');

        Route::get('/{item}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('show');
    });

    Route::prefix('merchants')->name('merchants.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\MerchantController::class, 'index'])->name('index');
        Route::get('/datatable', [App\Http\Controllers\Admin\MerchantController::class, 'dataTable'])->name('datatable');
        Route::get('/create', [App\Http\Controllers\Admin\MerchantController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Admin\MerchantController::class, 'store'])->name('store');
        Route::get('/edit/{item}', [App\Http\Controllers\Admin\MerchantController::class, 'edit'])->name('edit');
        Route::post('/update/{item}', [App\Http\Controllers\Admin\MerchantController::class, 'update'])->name('update');
        Route::post('/delete/{merchant}', [App\Http\Controllers\Admin\MerchantController::class, 'destroy'])->name('destroy');

        Route::get('/{item}', [App\Http\Controllers\Admin\MerchantController::class, 'show'])->name('show');
    });
    
    Route::prefix('menu_sub_categories')->name('menu_sub_categories.')->group(function () {
        Route::get('/{merchant_id}', [App\Http\Controllers\Admin\MenuSubCategoryController::class, 'index'])->name('index');
        Route::get('/{merchant_id}/datatable', [App\Http\Controllers\Admin\MenuSubCategoryController::class, 'dataTable'])->name('datatable');
        Route::get('/{merchant_id}/create', [App\Http\Controllers\Admin\MenuSubCategoryController::class, 'create'])->name('create');
        Route::post('/{merchant_id}/store', [App\Http\Controllers\Admin\MenuSubCategoryController::class, 'store'])->name('store');
        Route::get('/{merchant_id}/edit/{item}', [App\Http\Controllers\Admin\MenuSubCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{item}', [App\Http\Controllers\Admin\MenuSubCategoryController::class, 'update'])->name('update');
        Route::post('/delete/{menu_sub_category}', [App\Http\Controllers\Admin\MenuSubCategoryController::class, 'destroy'])->name('destroy');

        Route::get('/{merchant_id}/{item}', [App\Http\Controllers\Admin\MenuSubCategoryController::class, 'show'])->name('show');
    });

    Route::prefix('menu_foods')->name('menu_foods.')->group(function () {
        Route::get('/{merchant_id}', [App\Http\Controllers\Admin\MenuFoodController::class, 'index'])->name('index');
        Route::get('/{merchant_id}/datatable', [App\Http\Controllers\Admin\MenuFoodController::class, 'dataTable'])->name('datatable');
        Route::get('/{merchant_id}/create', [App\Http\Controllers\Admin\MenuFoodController::class, 'create'])->name('create');
        Route::post('/{merchant_id}/store', [App\Http\Controllers\Admin\MenuFoodController::class, 'store'])->name('store');
        Route::get('/{merchant_id}/edit/{item}', [App\Http\Controllers\Admin\MenuFoodController::class, 'edit'])->name('edit');
        Route::post('/update/{item}', [App\Http\Controllers\Admin\MenuFoodController::class, 'update'])->name('update');
        Route::post('/delete/{menu_food}', [App\Http\Controllers\Admin\MenuFoodController::class, 'destroy'])->name('destroy');

        Route::get('/{merchant_id}/{item}', [App\Http\Controllers\Admin\MenuFoodController::class, 'show'])->name('show');
    });

    Route::prefix('merchant_galleries')->name('merchant_galleries.')->group(function () {
        Route::get('/{merchant_id}', [App\Http\Controllers\Admin\MerchantGalleryController::class, 'index'])->name('index');
        Route::get('/{merchant_id}/datatable', [App\Http\Controllers\Admin\MerchantGalleryController::class, 'dataTable'])->name('datatable');
        Route::get('/{merchant_id}/create', [App\Http\Controllers\Admin\MerchantGalleryController::class, 'create'])->name('create');
        Route::post('/{merchant_id}/store', [App\Http\Controllers\Admin\MerchantGalleryController::class, 'store'])->name('store');
        Route::get('/{merchant_id}/edit/{item}', [App\Http\Controllers\Admin\MerchantGalleryController::class, 'edit'])->name('edit');
        Route::post('/update/{item}', [App\Http\Controllers\Admin\MerchantGalleryController::class, 'update'])->name('update');
        Route::post('/delete/{merchant_gallery}', [App\Http\Controllers\Admin\MerchantGalleryController::class, 'destroy'])->name('destroy');

        Route::get('/{merchant_id}/{item}', [App\Http\Controllers\Admin\MerchantGalleryController::class, 'show'])->name('show');
    });

    Route::prefix('banners')->name('banners.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\BannerController::class, 'index'])->name('index');
        Route::get('/datatable', [App\Http\Controllers\Admin\BannerController::class, 'dataTable'])->name('datatable');
        Route::get('/create', [App\Http\Controllers\Admin\BannerController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Admin\BannerController::class, 'store'])->name('store');
        Route::get('/edit/{item}', [App\Http\Controllers\Admin\BannerController::class, 'edit'])->name('edit');
        Route::post('/update/{item}', [App\Http\Controllers\Admin\BannerController::class, 'update'])->name('update');
        Route::post('/delete/{banner}', [App\Http\Controllers\Admin\BannerController::class, 'destroy'])->name('destroy');

        Route::get('/{item}', [App\Http\Controllers\Admin\BannerController::class, 'show'])->name('show');
    });

    Route::prefix('advertisements')->name('advertisements.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdvertisementController::class, 'index'])->name('index');
        Route::get('/datatable', [App\Http\Controllers\Admin\AdvertisementController::class, 'dataTable'])->name('datatable');
        Route::get('/create', [App\Http\Controllers\Admin\AdvertisementController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Admin\AdvertisementController::class, 'store'])->name('store');
        Route::get('/edit/{item}', [App\Http\Controllers\Admin\AdvertisementController::class, 'edit'])->name('edit');
        Route::post('/update/{item}', [App\Http\Controllers\Admin\AdvertisementController::class, 'update'])->name('update');
        Route::post('/delete/{advertisement}', [App\Http\Controllers\Admin\AdvertisementController::class, 'destroy'])->name('destroy');

        Route::get('/{item}', [App\Http\Controllers\Admin\AdvertisementController::class, 'show'])->name('show');
    });

    Route::get('notifications/datatable', [App\Http\Controllers\Admin\NotificationController::class, 'dataTable'])->name('notifications.datatable');
    Route::resource('notifications', NotificationController::class);
});
