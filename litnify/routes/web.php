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
    'register' => true, // Registration Routes...
    'reset' => true, // Password Reset Routes...
    'verify' => true, // Email Verification Routes...
]);

Route::get('/', function () {return view('start');})->name('start');
Route::get('/suche/{query?}', [App\Http\Controllers\SearchController::class, 'index'])->name('suche');
Route::post('/suche/export', [App\Http\Controllers\SearchController::class, 'export'])->name('suche.export');
//Route::get('/login', [App\Http\Controllers\LoginController::class])->name('login');
Route::get('/logout', [App\Http\Controllers\LogoutController::class, 'index'])->name('logout');

// * M o d e l s * //
/***********************************/
/*           User-Backend          */
/***********************************/
//Route::resource('user', 'App\Http\Controllers\UserController');
Route::permanentRedirect('/user', '/user/profil');
Route::permanentRedirect('/password', '/user/profil');
Route::get('/user/avatar/{name?}', [App\Http\Controllers\UserController::class, 'createAvatar'])->name('avatar')->middleware('auth');
Route::get('/user/profil', [App\Http\Controllers\UserController::class, 'showProfil'])->name('profil')->middleware('auth');
Route::get('/user/ausleihen', [App\Http\Controllers\UserController::class, 'showAusleihen'])->name('ausleihen')->middleware('auth');
Route::get('/user/merkliste', [App\Http\Controllers\UserController::class, 'showMerkliste'])->name('merkliste')->middleware('auth');

/***********************************/
/*        Medienverwaltung         */
/***********************************/
Route::get('medienverwaltung', [App\Http\Controllers\MediumController::class, 'index'])->name('medienverwaltung.index');
Route::get('medium/{medium}', [App\Http\Controllers\MediumController::class, 'show'])->name('medium.show')->where(array('medium' => '[0-9]+'));;
Route::resource('medienverwaltung/medium', MediumController::class)->only(['edit', 'store', 'update', 'destroy'])->where(array('medium' => '[0-9]+'));
Route::resource('medienverwaltung/medium',  App\Http\Controllers\MediumController::class)->only([
    'edit',  'store', 'update', 'destroy'
])->where(array('medium' => '[0-9]+'));
Route::get('medienverwaltung/medium/create', [App\Http\Controllers\MediumController::class, 'create'])->name('medium.createEmpty');
Route::get('medienverwaltung/medium/create/{literaturart}', [App\Http\Controllers\MediumController::class, 'create'])->name('medium.create');
Route::get('autor/{autor}', [App\Http\Controllers\MediumController::class, 'showAutor'])->name('autor.show');

/*  Freigabe    */
Route::get('medienverwaltung/freigabe', [App\Http\Controllers\FreigabeController::class, 'index'])->name('freigabe.index');
Route::put('medienverwaltung/{medium}/freigabe', [App\Http\Controllers\FreigabeController::class, 'update'])->name('freigabe.update')->where(array('medium' => '[0-9]+'));

/*  Zeitschriftenverwaltung */
Route::get('zeitschriftenverwaltung', [App\Http\Controllers\ZeitschriftController::class, 'index'])->name('zeitschriften.index');
Route::resource('medienverwaltung/zeitschrift', App\Http\Controllers\ZeitschriftController::class)->only([
    'edit', 'create', 'store', 'update', 'destroy'
])->where(array('zeitschrift' => '[0-9]+'));
/*  Inventarliste   */
/*   Inventarliste wird über die Lifewire Component verwaltet. Siehe: \App\Http\Livewire\InventarnummernComponent::class    */

/***********************************/
/*        Ausleihverwaltung        */
/***********************************/
Route::get('ausleihverwaltung', [App\Http\Controllers\AusleiheController::class, 'index'])->name('ausleihverwaltung.index');
Route::post('ausleihverwaltung/ausleihe/{user}/{medium}', [App\Http\Controllers\AusleiheController::class, 'store'])->where(array('user' => '[0-9]+', 'medium' => '[0-9]+'))->name('ausleihe.store');
Route::get('ausleihverwaltung/ausleihen/{ausleihe}', [App\Http\Controllers\AusleiheController::class, 'show'])->where(array('user' => '[0-9]+'))->name('ausleihe.show');
Route::resource('ausleihverwaltung/ausleihe', App\Http\Controllers\AusleiheController::class)->only([
    'edit', 'update', 'destroy'
])->where(array('ausleihe' => '[0-9]+'));
Route::put('ausleihverwaltung/ausleihe/{ausleihe}/verlaengern', [App\Http\Controllers\AusleiheController::class, 'updateVerlaegerungen'])->where(array('ausleihe' => '[0-9]+'))->name('ausleihe.extend');
Route::put('ausleihverwaltung/ausleihe/{ausleihe}/rueckgabe', [App\Http\Controllers\AusleiheController::class, 'updateRueckgabe'])->where(array('ausleihe' => '[0-9]+'))->name('ausleihe.return');

/*  Direktverleih   */
Route::get('ausleihverwaltung/direktverleih', [App\Http\Controllers\DirektverleihController::class, 'index'])->name('direktverleih.index');
Route::get('ausleihverwaltung/direktverleih/create/{user}', [App\Http\Controllers\DirektverleihController::class, 'create'])->name('direktverleih.create');

/*  Merklistenverleih   */
Route::get('ausleihverwaltung/merklistenverleih', [App\Http\Controllers\MerklistenverleihController::class, 'index'])->name('merklistenverleih.index');
Route::get('ausleihverwaltung/merklistenverleih/{user}', [App\Http\Controllers\MerklistenverleihController::class, 'show'])->where(array('user' => '[0-9]+'))->name('merklistenverleih.show');

// * A d m i n P a g e  s * //
Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function(){

    Route::get('nutzerverwaltung', [App\Http\Controllers\UserController::class, 'index'])->name('admin.nutzerverwaltung');
    Route::get('ausleihverwaltung', [App\Http\Controllers\UserController::class, 'index'])->name('admin.ausleihverwaltung');
    Route::get('systemverwaltung', [App\Http\Controllers\Admin\SystemController::class, 'index'])->name('admin.systemverwaltung')->middleware('auth', 'role:4');
    Route::get('systemverwaltung/auswertungen', [App\Http\Controllers\Admin\SystemController::class, 'auswertungen'])->name('admin.systemverwaltung.auswertungen')->middleware('auth', 'role:4');
    Route::get('systemverwaltung/contenteditor', [App\Http\Controllers\Admin\SystemController::class, 'contentEditor'])->name('admin.systemverwaltung.contenteditor')->middleware('auth', 'role:4');
    Route::post('systemverwaltung/contenteditor', [App\Http\Controllers\Admin\SystemController::class, 'contentEditorUpdate'])->middleware('auth', 'role:4');
    Route::get('systemverwaltung/logs', [App\Http\Controllers\Admin\SystemController::class, 'logs'])->name('admin.systemverwaltung.logs')->middleware('auth', 'role:4');

    //Route::get('users', 'App\Http\Controllers\Admin\UserController');
    //Route::get('medium', 'App\Http\Controllers\Admin\MediumController');
    //Route::get('system', 'App\Http\Controllers\Admin\SystemController');

});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test', [App\Http\Controllers\Download::class, 'index']);


// * S t a t i c P a g e  s * //
Route::get('/{page}', App\Http\Controllers\SeitenController::class)->name('page');


