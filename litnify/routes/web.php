<?php

use Illuminate\Support\Facades\Auth;
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
Auth::routes([
    //'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/', function () {
    return view('start');
});

// * S t a t i c P a g e  s * //
Route::get('/pages/{name}/{action?}', [App\Http\Controllers\StaticPagesController::class, 'index'])->name('static-pages');
Route::get('/search/{query?}', [App\Http\Controllers\SearchController::class, 'index'])->name('search');
Route::get('/logout', [App\Http\Controllers\LogoutController::class, 'index'])->name('logout');

// * M o d e l s * //
// User
Route::get('/user', [UserController::class, 'index']);
Route::get('user/{id}', function ($id) {})->where('id', '[0-9]+');

// Medium
Route::get('medium/{id}/{action}', function ($id, $action) {})->where(['id' => '[0-9]+', 'action' => '[a-z]+']);
// Ausleihe



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



