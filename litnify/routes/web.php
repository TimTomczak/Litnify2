<?php

use App\Http\Controllers\AusleiheController;
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
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/', function () {
    return view('start');
})->name('start');

Route::get('/suche/{query?}', [App\Http\Controllers\SearchController::class, 'index'])->name('suche');
//Route::get('/login', [App\Http\Controllers\LoginController::class])->name('login');
Route::get('/logout', [App\Http\Controllers\LogoutController::class, 'index'])->name('logout');

// * M o d e l s * //
/***********************************/
/*             User                */
/***********************************/
//Route::resource('user', 'App\Http\Controllers\UserController');
Route::get('/user/profil', [App\Http\Controllers\UserController::class, 'showProfil'])->name('profil')->middleware('auth');
Route::get('/user/ausleihen', [App\Http\Controllers\UserController::class, 'showAusleihen'])->name('ausleihen')->middleware('auth');
Route::get('/user/merkliste', [App\Http\Controllers\UserController::class, 'showMerkliste'])->name('merkliste')->middleware('auth');

/***********************************/
/*        Medienverwaltung         */
/***********************************/
Route::get('medienverwaltung', [App\Http\Controllers\MediumController::class, 'index'])->name('medienverwaltung.index');
Route::get('medium/{medium}', [App\Http\Controllers\MediumController::class, 'show'])->name('medium.show')->where(array('medium' => '[0-9]+'));;
Route::resource('medienverwaltung/medium', MediumController::class)->only([
    'edit', 'create', 'store', 'update', 'destroy'
])->where(array('medium' => '[0-9]+'));
Route::get('medienverwaltung/medium/create/{literaturart}', [App\Http\Controllers\MediumController::class, 'create'])->name('medium.create');

/*  Freigabe    */
Route::get('medienverwaltung/freigabe', [App\Http\Controllers\FreigabeController::class, 'index'])->name('freigabe.index');
Route::put('medienverwaltung/{medium}/freigabe', [App\Http\Controllers\FreigabeController::class, 'update'])->name('freigabe.update')->where(array('medium' => '[0-9]+'));

/*  Zeitschriftenverwaltung */
Route::get('medienverwaltung/zeitschriften', [App\Http\Controllers\ZeitschriftController::class, 'index'])->name('zeitschriften.index');
Route::resource('medienverwaltung/zeitschrift', ZeitschriftController::class)->only([
    'edit', 'create', 'store', 'update', 'destroy'
])->where(array('zeitschrift' => '[0-9]+'));
/*  Inventarliste   */
/*   Inventarliste wird über die Lifewire Component verwaltet. Siehe: \App\Http\Livewire\InventarnummernComponent::class    */

/***********************************/
/*        Ausleihverwaltung        */
/***********************************/
Route::get('ausleihverwaltung', [App\Http\Controllers\AusleiheController::class, 'index'])->name('ausleihverwaltung.index');
Route::post('ausleihverwaltung/ausleihe/{user}/{medium}', [App\Http\Controllers\AusleiheController::class, 'store'])->where(array('user' => '[0-9]+', 'medium' => '[0-9]+'))->name('ausleihe.store');
Route::get('ausleihverwaltung/ausleihen/{user}', [App\Http\Controllers\AusleiheController::class, 'show'])->where(array('user' => '[0-9]+'))->name('ausleihe.show');

/*  Direktverleih   */
Route::get('ausleihverwaltung/direktverleih', [App\Http\Controllers\DirektverleihController::class, 'index'])->name('direktverleih.index');
Route::get('ausleihverwaltung/direktverleih/create', [App\Http\Controllers\DirektverleihController::class, 'create'])->name('direktverleih.create');

/*  Merklistenverleih   */
Route::get('ausleihverwaltung/merklistenverleih', [App\Http\Controllers\MerklistenverleihController::class, 'index'])->name('merklistenverleih.index');
Route::get('ausleihverwaltung/merklistenverleih/{user}', [App\Http\Controllers\MerklistenverleihController::class, 'show'])->where(array('user' => '[0-9]+'))->name('merklistenverleih.show');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// * S t a t i c P a g e  s * //
Route::get('/{page}', App\Http\Controllers\StaticPagesController::class)->name('page');

