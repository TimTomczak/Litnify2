<?php

use App\Http\Controllers\MediumController;
use App\Http\Controllers\ZeitschriftController;
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
    'register' => true, // Registration Routes...
    'reset' => true, // Password Reset Routes...
    'verify' => true, // Email Verification Routes...
]);

Route::get('/', function () {
    return view('start');
})->name('start');

Route::get('/suche/{query?}', [App\Http\Controllers\SearchController::class, 'index'])->name('suche');
Route::get('/logout', [App\Http\Controllers\LogoutController::class, 'index'])->name('logout');

// * M o d e l s * //
// User-Backend
//Route::resource('user', 'App\Http\Controllers\UserController');
Route::permanentRedirect('/user', '/user/profil');
Route::permanentRedirect('/password', '/user/profil');
Route::get('/user/profil', [App\Http\Controllers\UserController::class, 'showProfil'])->name('profil')->middleware('auth');
Route::get('/user/ausleihen', [App\Http\Controllers\UserController::class, 'showAusleihen'])->name('ausleihen')->middleware('auth');
Route::get('/user/merkliste', [App\Http\Controllers\UserController::class, 'showMerkliste'])->name('merkliste')->middleware('auth');



// Medienverwaltung
//Route::get('medium/{id}/{action}', function ($id, $action) {})->where(['id' => '[0-9]+', 'action' => '[a-z]+']);
Route::get('medienverwaltung', [App\Http\Controllers\MediumController::class, 'index'])->name('medienverwaltung.index');
Route::get('medium/{medium}', [App\Http\Controllers\MediumController::class, 'show'])->name('medium.show')->where(array('medium' => '[0-9]+'));;
Route::resource('medienverwaltung/medium', MediumController::class)->only([
    'edit', 'create', 'store', 'update', 'destroy'
])->where(array('medium' => '[0-9]+'));
Route::get('medienverwaltung/medium/create/{literaturart}', [App\Http\Controllers\MediumController::class, 'create'])->name('medium.create');

// Freigabe
Route::get('medienverwaltung/freigabe', [App\Http\Controllers\FreigabeController::class, 'index'])->name('freigabe.index');
Route::put('medienverwaltung/{medium}/freigabe', [App\Http\Controllers\FreigabeController::class, 'update'])->name('freigabe.update')->where(array('medium' => '[0-9]+'));

//Zeitschriften
Route::get('medienverwaltung/zeitschriften', [App\Http\Controllers\ZeitschriftController::class, 'index'])->name('zeitschriften.index');
Route::resource('medienverwaltung/zeitschrift', ZeitschriftController::class)->only([
    'edit', 'create', 'store', 'update', 'destroy'
])->where(array('zeitschrift' => '[0-9]+'));
//Inventarliste
// Inventarliste wird über die Lifewire Component verwaltet. Siehe: \App\Http\Livewire\InventarnummernComponent::class

// Ausleihe
Route::get('ausleihe/{id?}/{action?}', [App\Http\Controllers\AusleiheController::class, 'index'])->name('ausleihe');


// * A d m i n P a g e  s * //
Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function(){

    Route::get('nutzerverwaltung', [App\Http\Controllers\UserController::class, 'index'])->name('admin.nutzerverwaltung');
    Route::get('ausleihverwaltung', [App\Http\Controllers\UserController::class, 'index'])->name('admin.ausleihverwaltung');
    Route::get('systemverwaltung', [App\Http\Controllers\UserController::class, 'index'])->name('admin.systemverwaltung');
    Route::get('systemverwaltung/auswertungen', [App\Http\Controllers\UserController::class, 'index'])->name('admin.systemverwaltung.auswertungen');
    Route::get('systemverwaltung/contenteditor', [App\Http\Controllers\UserController::class, 'index'])->name('admin.systemverwaltung.contenteditor');

    //Route::get('users', 'App\Http\Controllers\Admin\UserController');
    //Route::get('medium', 'App\Http\Controllers\Admin\MediumController');
    //Route::get('system', 'App\Http\Controllers\Admin\SystemController');

});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// * S t a t i c P a g e  s * //
Route::get('/{page}', App\Http\Controllers\StaticPagesController::class)->name('page');

