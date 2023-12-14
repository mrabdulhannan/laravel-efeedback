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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/definecategories', [App\Http\Controllers\CategoriesController::class, 'create'])->name('definecategories');

Route::post('/storecategories', [App\Http\Controllers\CategoriesController::class, 'store'])->name('storecategories');

Route::get('/mycategories', [App\Http\Controllers\HomeController::class, 'mycategories'])->name('mycategories');

Route::get('/newassesment', [App\Http\Controllers\HomeController::class, 'newassesment'])->name('newassesment');

Route::get('/previewpage', [App\Http\Controllers\HomeController::class, 'previewpage'])->name('previewpage');


Route::get('log-in', function () {
    return view('auth/login');
})->name('log-in');

Route::get('signup', function () {
    return view('auth/register');
})->name('signup');

Route::get('forgetpassword', function () {
    return view('auth/forgetpassword');
})->name('forgetpassword');