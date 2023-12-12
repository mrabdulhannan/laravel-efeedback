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
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('login', function () {
    return view('auth/login');
})->name('login');

Route::get('register', function () {
    return view('auth/register');
})->name('register');

Route::get('definecategories', function () {
    return view('admin/definecategories');
})->name('definecategories');

Route::get('mycategories', function () {
    return view('admin/mycategories');
})->name('mycategories');

Route::get('newassesment', function () {
    return view('admin/newassesment');
})->name('newassesment');

Route::get('previewpage', function () {
    return view('admin/previewpage');
})->name('previewpage');

Route::get('forgetpassword', function () {
    return view('auth/forgetpassword');
})->name('forgetpassword');