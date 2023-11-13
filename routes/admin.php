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


Route::get('/download-app', function () {
    return view('download-app');
});


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


    Route::prefix('merchant_reviews')->name('merchant_reviews.')->group(function () {
        Route::get('/{merchant_id}', [App\Http\Controllers\Admin\MerchantReviewController::class, 'index'])->name('index');
        Route::get('/{merchant_id}/datatable', [App\Http\Controllers\Admin\MerchantReviewController::class, 'dataTable'])->name('datatable');
        Route::post('/delete/{review}', [App\Http\Controllers\Admin\MerchantReviewController::class, 'destroy'])->name('destroy');

        Route::get('/{merchant_id}/{item}', [App\Http\Controllers\Admin\MerchantReviewController::class, 'show'])->name('show');
    });
    
    Route::prefix('review_comments')->name('review_comments.')->group(function () {
        Route::get('/{review_id}', [App\Http\Controllers\Admin\ReviewCommentController::class, 'index'])->name('index');
        Route::get('/{review_id}/datatable', [App\Http\Controllers\Admin\ReviewCommentController::class, 'dataTable'])->name('datatable');        
        Route::get('/reports/{comment_id}/datatable', [App\Http\Controllers\Admin\ReviewCommentController::class, 'reportDataTable'])->name('reports.datatable');
        Route::post('/reports/delete/{report}', [App\Http\Controllers\Admin\ReviewCommentController::class, 'reportDestroy'])->name('reports.destroy');

        Route::post('/delete/{comment}', [App\Http\Controllers\Admin\ReviewCommentController::class, 'destroy'])->name('destroy');

        Route::get('/{review_id}/{item}', [App\Http\Controllers\Admin\ReviewCommentController::class, 'show'])->name('show');
    });
    
    Route::prefix('review_reports')->name('review_reports.')->group(function () {
        Route::get('/{review_id}', [App\Http\Controllers\Admin\ReviewReportController::class, 'index'])->name('index');
        Route::get('/{review_id}/datatable', [App\Http\Controllers\Admin\ReviewReportController::class, 'dataTable'])->name('datatable');
        Route::post('/delete/{report}', [App\Http\Controllers\Admin\ReviewReportController::class, 'destroy'])->name('destroy');

        Route::get('/{review_id}/{item}', [App\Http\Controllers\Admin\ReviewReportController::class, 'show'])->name('show');
    });

    Route::prefix('merchant_categories')->name('merchants.categories.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('index');
        Route::get('/datatable', [App\Http\Controllers\Admin\CategoryController::class, 'dataTable'])->name('datatable');
        Route::get('/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{item}', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{item}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('update');
        Route::post('/delete/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('destroy');

        Route::get('/{item}', [App\Http\Controllers\Admin\CategoryController::class, 'show'])->name('show');
    });

    Route::prefix('merchant_sub_categories')->name('merchants.sub_categories.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SubCategoryController::class, 'index'])->name('index');
        Route::get('/datatable', [App\Http\Controllers\Admin\SubCategoryController::class, 'dataTable'])->name('datatable');
        Route::get('/create', [App\Http\Controllers\Admin\SubCategoryController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Admin\SubCategoryController::class, 'store'])->name('store');
        Route::get('/edit/{item}', [App\Http\Controllers\Admin\SubCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{item}', [App\Http\Controllers\Admin\SubCategoryController::class, 'update'])->name('update');
        Route::post('/delete/{sub_category}', [App\Http\Controllers\Admin\SubCategoryController::class, 'destroy'])->name('destroy');

        Route::get('/{item}', [App\Http\Controllers\Admin\CategoryController::class, 'show'])->name('show');
    });

    Route::prefix('merchant_moods')->name('merchants.moods.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\MoodController::class, 'index'])->name('index');
        Route::get('/datatable', [App\Http\Controllers\Admin\MoodController::class, 'dataTable'])->name('datatable');
        Route::get('/create', [App\Http\Controllers\Admin\MoodController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Admin\MoodController::class, 'store'])->name('store');
        Route::get('/edit/{item}', [App\Http\Controllers\Admin\MoodController::class, 'edit'])->name('edit');
        Route::post('/update/{item}', [App\Http\Controllers\Admin\MoodController::class, 'update'])->name('update');
        Route::post('/delete/{mood}', [App\Http\Controllers\Admin\MoodController::class, 'destroy'])->name('destroy');

        Route::get('/{item}', [App\Http\Controllers\Admin\MoodController::class, 'show'])->name('show');
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

    Route::prefix('announcements')->name('announcements.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AnnouncementController::class, 'index'])->name('index');
        Route::get('/datatable', [App\Http\Controllers\Admin\AnnouncementController::class, 'dataTable'])->name('datatable');
        Route::get('/create', [App\Http\Controllers\Admin\AnnouncementController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Admin\AnnouncementController::class, 'store'])->name('store');
        Route::get('/edit/{item}', [App\Http\Controllers\Admin\AnnouncementController::class, 'edit'])->name('edit');
        Route::post('/update/{item}', [App\Http\Controllers\Admin\AnnouncementController::class, 'update'])->name('update');
        Route::post('/delete/{announcement}', [App\Http\Controllers\Admin\AnnouncementController::class, 'destroy'])->name('destroy');

        Route::get('/{item}', [App\Http\Controllers\Admin\AnnouncementController::class, 'show'])->name('show');
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
    Route::prefix('features')->name('features.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\FeatureController::class, 'index'])->name('index');
        Route::get('/datatable', [App\Http\Controllers\Admin\FeatureController::class, 'dataTable'])->name('datatable');
        Route::get('/create', [App\Http\Controllers\Admin\FeatureController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Admin\FeatureController::class, 'store'])->name('store');
        Route::get('/edit/{item}', [App\Http\Controllers\Admin\FeatureController::class, 'edit'])->name('edit');
        Route::post('/update/{item}', [App\Http\Controllers\Admin\FeatureController::class, 'update'])->name('update');
        Route::post('/delete/{feature_category}', [App\Http\Controllers\Admin\FeatureController::class, 'destroy'])->name('destroy');

        Route::get('/{item}', [App\Http\Controllers\Admin\FeatureController::class, 'show'])->name('show');
    });
    
    Route::prefix('feedbacks')->name('feedbacks.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\FeedbackController::class, 'index'])->name('index');
        Route::get('/datatable', [App\Http\Controllers\Admin\FeedbackController::class, 'dataTable'])->name('datatable');
    });

    Route::get('notifications/datatable', [App\Http\Controllers\Admin\NotificationController::class, 'dataTable'])->name('notifications.datatable');
    Route::resource('notifications', NotificationController::class);
});
