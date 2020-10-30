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

Route::get('/suche/{query?}', [App\Http\Controllers\SearchController::class, 'index'])->name('suche');
Route::get('/logout', [App\Http\Controllers\LogoutController::class, 'index'])->name('logout');

// * M o d e l s * //
// User
Route::get('/account/{action?}', [App\Http\Controllers\UserController::class, 'showUser'])->name('account')->middleware('auth');
//Route::resource('user', 'App\Http\Controllers\UserController');
Route::get('/account/ausleihen', [App\Http\Controllers\AusleiheController::class, 'showUser'])->name('ausleihen')->middleware('auth');
Route::get('/account/merkliste', [App\Http\Controllers\MerklisteController::class, 'showUser'])->name('merkliste')->middleware('auth');



// Medium
Route::get('medium/{id}/{action}', function ($id, $action) {})->where(['id' => '[0-9]+', 'action' => '[a-z]+']);
// Ausleihe
Route::get('ausleihe/{id?}/{action?}', [App\Http\Controllers\AusleiheController::class, 'index'])->name('ausleihe');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// * S t a t i c P a g e  s * //
Route::get('/{page}', App\Http\Controllers\StaticPagesController::class)->name('page');

