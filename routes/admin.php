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
});
