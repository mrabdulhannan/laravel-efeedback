<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;


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

// Route::get('/rubrics', function () {
//     return view('admin.rubrics');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/definecategories', [App\Http\Controllers\CategoriesController::class, 'create'])->name('definecategories');

Route::post('/storecategories', [App\Http\Controllers\CategoriesController::class, 'store'])->name('storecategories');

Route::get('/mycategories', [App\Http\Controllers\HomeController::class, 'mycategories'])->name('mycategories');

Route::get('/newassesment', [App\Http\Controllers\HomeController::class, 'newassesment'])->name('newassesment');

Route::get('/previewpage', [App\Http\Controllers\CategoriesController::class, 'showData'])->name('previewpage');

Route::get('/updatepassword', [App\Http\Controllers\HomeController::class, 'updatepassword'])->name('updatepassword');


Route::get('log-in', function () {
    return view('auth/login');
})->name('log-in');

Route::get('signup', function () {
    return view('auth/register');
})->name('signup');

Route::get('forgetpassword', function () {
    return view('auth/forgetpassword');
})->name('forgetpassword');


Route::post('/updatepassword', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('updatepassword');

Route::delete('/deleteCategory/{id}', [App\Http\Controllers\CategoriesController::class, 'deleteCategory'])->name('deleteCategory');

Route::put('/updateCategory/{id}', [App\Http\Controllers\CategoriesController::class, 'updateCategory'])->name('updateCategory');
Route::post('/editCategory/{id}', [App\Http\Controllers\CategoriesController::class, 'editCategory'])->name('editCategory');

// Topics Relevent Routes
Route::get('/definetopic', [App\Http\Controllers\TopicsController::class, 'create'])->name('definetopic');
Route::post('/storetopic', [App\Http\Controllers\TopicsController::class, 'store'])->name('storetopic');
Route::patch('/updatetopic/{topicId}', [App\Http\Controllers\TopicsController::class, 'updatetopicpost'])->name('updatetopicpost');
Route::post('/edittopic/{id}', [App\Http\Controllers\TopicsController::class, 'edittopic'])->name('edittopic.post');
Route::get('/edittopic/{id}', [App\Http\Controllers\TopicsController::class, 'edittopic'])->name('edittopic.get');
Route::get('/alltopics', [App\Http\Controllers\TopicsController::class, 'showalltopics'])->name('alltopics');
Route::delete('/deletetopic/{id}', [App\Http\Controllers\TopicsController::class, 'deletetopic'])->name('deletetopic');


//Rubrics Relevent Routes
Route::get('/rubrics', [App\Http\Controllers\RubricsController::class, 'create'])->name('rubrics');
Route::post('/storerubrics', [App\Http\Controllers\RubricsController::class, 'store'])->name('storerubrics');
Route::put('/updaterubrics/{id}', [App\Http\Controllers\RubricsController::class, 'updaterubrics'])->name('updaterubrics');