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
    'register' => false, // Registration Routes...
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
//Route::get('/user', [UserController::class, 'index']);
Route::get('user/{id}', function ($id) {})->where('id', '[0-9]+');

// Medium
//Route::get('medium/{id}/{action}', function ($id, $action) {})->where(['id' => '[0-9]+', 'action' => '[a-z]+']);
Route::get('medienverwaltung', [App\Http\Controllers\MediumController::class, 'index'])->name('medienverwaltung.index');
Route::get('medium/{medium}', [App\Http\Controllers\MediumController::class, 'show'])->name('medium.show');
Route::resource('medienverwaltung/medium', \App\Http\Controllers\MediumController::class)->only([
    'edit', 'create', 'store', 'update', 'destroy'
])->where(array('medium' => '[0-9]+'));
Route::get('medienverwaltung/medium/create/{literaturart}', [App\Http\Controllers\MediumController::class, 'create'])->name('medium.create');

// Ausleihe
Route::get('ausleihe/{id?}/{action?}', [App\Http\Controllers\AusleiheController::class, 'index'])->name('ausleihe');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



