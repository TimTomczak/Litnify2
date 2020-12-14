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
    'reset' => true, // Password Reset Routes...
    'verify' => true, // Email Verification Routes...
]);

//Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('role:4');

Route::get('/', function () {return view('start',['auswahl'=>App\Helpers\Helper::$suchFilter]);})->name('start');
Route::get('/suche/{query?}', [App\Http\Controllers\SearchController::class, 'index'])->name('suche');
Route::post('/suche/export', [App\Http\Controllers\SearchController::class, 'export'])->name('suche.export');
//Route::get('/login', [App\Http\Controllers\LoginController::class])->name('login');
Route::get('/logout', [App\Http\Controllers\LogoutController::class, 'index'])->name('logout');

// * M o d e l s * //
/***********************************/
/*           User-Backend          */
/***********************************/
//Route::resource('user', 'App\Http\Controllers\UserController');
Route::middleware('blocked')->group( function() {
    Route::permanentRedirect('/user', '/user/profil');
    Route::permanentRedirect('/password', '/user/profil');
    Route::get('/user/avatar/{name?}', [App\Http\Controllers\UserController::class, 'createAvatar'])->name('avatar')->middleware('auth');
    Route::get('/user/profil', [App\Http\Controllers\UserController::class, 'showProfil'])->name('profil.show')->middleware('auth');
    Route::get('/user/ausleihen', [App\Http\Controllers\UserController::class, 'showAusleihen'])->name('ausleihen.show')->middleware('auth');
    Route::get('/user/merkliste', [App\Http\Controllers\UserController::class, 'showMerkliste'])->name('merkliste.show')->middleware('auth');
    Route::post('/user/merkliste', [App\Http\Controllers\UserController::class, 'editMerkliste'])->name('merkliste.edit')->middleware('auth');

    Route::get('medium/{medium}', [App\Http\Controllers\MediumController::class, 'show'])->name('medium.show')->where(array('medium' => '[0-9]+'));
    Route::get('autor/{autor}', [App\Http\Controllers\MediumController::class, 'showAutor'])->name('autor.show');
});

// * A d m i n P a g e  s * //
Route::group(['prefix' => 'admin',  'middleware' => ['auth','blocked','log']], function(){

    /***********************************/
    /*        Medienverwaltung         */
    /***********************************/
    Route::get('medienverwaltung', [App\Http\Controllers\MediumController::class, 'index'])->name('medienverwaltung.index')->middleware('role:2', 'blocked');
    Route::get('medienverwaltung/medium/create', [App\Http\Controllers\MediumController::class, 'create'])->name('medium.createEmpty')->middleware('role:2');
    Route::get('medienverwaltung/medium/create/{literaturart}', [App\Http\Controllers\MediumController::class, 'create'])->name('medium.create')->middleware('role:2');
    Route::post('medienverwaltung/medium', [App\Http\Controllers\MediumController::class, 'store'])->name('medium.store')->where(array('medium' => '[0-9]+'))->middleware('role:2');
    Route::get('medienverwaltung/medium/{medium}/edit', [App\Http\Controllers\MediumController::class, 'edit'])->name('medium.edit')->where(array('medium' => '[0-9]+'))->middleware('role:2');
    Route::put('medienverwaltung/medium/{medium}', [App\Http\Controllers\MediumController::class, 'update'])->name('medium.update')->where(array('medium' => '[0-9]+'))->middleware('role:2');
    Route::put('medienverwaltung/medium/{medium}/recover', [App\Http\Controllers\MediumController::class, 'recover'])->name('medium.recover')->where(array('medium' => '[0-9]+'))->middleware('role:2');
    Route::delete('medienverwaltung/medium/{medium}', [App\Http\Controllers\MediumController::class, 'destroy'])->name('medium.destroy')->where(array('medium' => '[0-9]+'))->middleware('role:3');
    /*  Freigabe    */
    /*TODO Freigabe rückgängig machen ? */
    Route::get('medienverwaltung/freigabe', [App\Http\Controllers\FreigabeController::class, 'index'])->name('freigabe.index')->middleware('role:2');
    Route::put('medienverwaltung/{medium}/freigabe', [App\Http\Controllers\FreigabeController::class, 'update'])->name('freigabe.update')->where(array('medium' => '[0-9]+'))->middleware('role:3');
    /*  Zeitschriftenverwaltung */
    Route::get('zeitschriftenverwaltung', [App\Http\Controllers\ZeitschriftController::class, 'index'])->name('zeitschriften.index')->middleware('role:2');
    Route::get('zeitschriftenverwaltung/zeitschrift/{zeitschrift}/edit', [App\Http\Controllers\ZeitschriftController::class, 'edit'])->name('zeitschrift.edit')->middleware('role:2');
    Route::get('zeitschriftenverwaltung/zeitschrift/create', [App\Http\Controllers\ZeitschriftController::class, 'create'])->name('zeitschrift.create')->middleware('role:2');
    Route::post('zeitschriftenverwaltung/zeitschrift', [App\Http\Controllers\ZeitschriftController::class, 'store'])->name('zeitschrift.store')->middleware('role:2');
    Route::put('zeitschriftenverwaltung/zeitschrift/{zeitschrift}', [App\Http\Controllers\ZeitschriftController::class, 'update'])->name('zeitschrift.update')->middleware('role:3');
    Route::put('zeitschriftenverwaltung/zeitschrift/{zeitschrift}/recover', [App\Http\Controllers\ZeitschriftController::class, 'recover'])->name('zeitschrift.recover')->middleware('role:3');
    Route::delete('zeitschriftenverwaltung/zeitschrift/{zeitschrift}', [App\Http\Controllers\ZeitschriftController::class, 'destroy'])->name('zeitschrift.destroy')->middleware('role:3');
    /*  Inventarliste   */
    /*   Inventarliste wird über die Lifewire Component verwaltet. Siehe: \App\Http\Livewire\InventarnummernComponent::class    */

    /***********************************/
    /*        Ausleihverwaltung        */
    /***********************************/
    Route::get('ausleihverwaltung', [App\Http\Controllers\AusleiheController::class, 'index'])->name('ausleihverwaltung.index')->middleware('role:2');
    Route::get('ausleihverwaltung/ausleihen-beendet', [App\Http\Controllers\AusleiheController::class, 'indexAusleihenBeendet'])->name('ausleihenBeendet.index')->middleware('role:2');
    Route::post('ausleihverwaltung/ausleihe/{user}/{medium}', [App\Http\Controllers\AusleiheController::class, 'store'])->where(array('user' => '[0-9]+', 'medium' => '[0-9]+'))->name('ausleihe.store')->middleware('role:3');
    Route::get('ausleihverwaltung/ausleihen/{ausleihe}', [App\Http\Controllers\AusleiheController::class, 'show'])->where(array('user' => '[0-9]+'))->name('ausleihe.show')->middleware('role:2');
    Route::get('ausleihverwaltung/ausleihen/{ausleihe}/edit', [App\Http\Controllers\AusleiheController::class, 'edit'])->where(array('user' => '[0-9]+'))->name('ausleihe.edit')->middleware('role:3');
    Route::put('ausleihverwaltung/ausleihen/{ausleihe}', [App\Http\Controllers\AusleiheController::class, 'update'])->where(array('user' => '[0-9]+'))->name('ausleihe.update')->middleware('role:3');
    Route::delete('ausleihverwaltung/ausleihen/{ausleihe}', [App\Http\Controllers\AusleiheController::class, 'destroy'])->where(array('user' => '[0-9]+'))->name('ausleihe.destroy')->middleware('role:3');
    Route::put('ausleihverwaltung/ausleihe/{ausleihe}/verlaengern', [App\Http\Controllers\AusleiheController::class, 'updateVerlaegerungen'])->where(array('ausleihe' => '[0-9]+'))->name('ausleihe.extend')->middleware('role:3');
    Route::put('ausleihverwaltung/ausleihe/{ausleihe}/rueckgabe', [App\Http\Controllers\AusleiheController::class, 'updateRueckgabe'])->where(array('ausleihe' => '[0-9]+'))->name('ausleihe.return')->middleware('role:3');
    Route::put('ausleihverwaltung/ausleihe/{ausleihe}/recover', [App\Http\Controllers\AusleiheController::class, 'recover'])->where(array('ausleihe' => '[0-9]+'))->name('ausleihe.recover')->middleware('role:3');
    /*  Direktverleih   */
    Route::get('ausleihverwaltung/direktverleih', [App\Http\Controllers\DirektverleihController::class, 'index'])->name('direktverleih.index')->middleware('role:3');
    Route::get('ausleihverwaltung/direktverleih/create/{user}', [App\Http\Controllers\DirektverleihController::class, 'create'])->name('direktverleih.create')->middleware('role:3');
    /*  Merklistenverleih   */
    Route::get('ausleihverwaltung/merklistenverleih', [App\Http\Controllers\MerklistenverleihController::class, 'index'])->name('merklistenverleih.index')->middleware('role:3');
    Route::get('ausleihverwaltung/merklistenverleih/{user}', [App\Http\Controllers\MerklistenverleihController::class, 'show'])->where(array('user' => '[0-9]+'))->name('merklistenverleih.show')->middleware('role:3');

    /***********************************/
    /*        Wiederherstellung        */
    /***********************************/
    Route::get('wiederherstellung/{verwaltung}', [App\Http\Controllers\WiederherstellungController::class, 'show'])->name('wiederherstellung.show')->middleware('role:3');


    /***********************************/
    /*        Nutzerverwaltung         */
    /***********************************/
    Route::get('nutzerverwaltung', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.nutzerverwaltung')->middleware('role:4');
    Route::get('nutzerverwaltung/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.nutzerverwaltung.create')->middleware('role:4');
    Route::post('nutzerverwaltung/createUser', [App\Http\Controllers\Admin\UserController::class, 'createUser'])->name('admin.nutzerverwaltung.createUser')->middleware('role:4');
    Route::get('nutzerverwaltung/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.nutzerverwaltung.edit')->middleware('role:4');
    Route::post('nutzerverwaltung/{user}/update', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.nutzerverwaltung.update')->middleware('role:4');
    Route::post('nutzerverwaltung/{user}/delete', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.nutzerverwaltung.delete')->middleware('role:4');
    Route::post('nutzerverwaltung/{user}/wakeup', [App\Http\Controllers\Admin\UserController::class, 'wakeUp'])->name('admin.nutzerverwaltung.wakeup')->middleware('role:4');


    /***********************************/
    /*        Systemverwaltung         */
    /***********************************/
    Route::get('systemverwaltung', [App\Http\Controllers\Admin\SystemController::class, 'index'])->name('admin.systemverwaltung')->middleware('role:4');
    Route::get('systemverwaltung/auswertungen', [App\Http\Controllers\Admin\SystemController::class, 'auswertungen'])->name('admin.systemverwaltung.auswertungen')->middleware('role:4');
    Route::get('systemverwaltung/contenteditor', [App\Http\Controllers\Admin\SystemController::class, 'contentEditor'])->name('admin.systemverwaltung.contenteditor')->middleware('role:4');
    Route::post('systemverwaltung/contenteditor', [App\Http\Controllers\Admin\SystemController::class, 'contentEditorUpdate'])->middleware('role:4');
    Route::post('systemverwaltung/updateLogo', [App\Http\Controllers\Admin\SystemController::class, 'updateLogo'])->name('admin.systemverwaltung.updateLogo')->middleware('role:4');
    Route::get('systemverwaltung/logs', [App\Http\Controllers\Admin\SystemController::class, 'logs'])->name('admin.systemverwaltung.logs')->middleware('role:4');

    //Route::get('users', 'App\Http\Controllers\Admin\UserController');
    //Route::get('medium', 'App\Http\Controllers\Admin\MediumController');
    //Route::get('system', 'App\Http\Controllers\Admin\SystemController');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test', [App\Http\Controllers\DownloadController::class, 'index']);

Route::get('/aaa', function (){
    $file=storage_path("sql\medien.sql");
//    $file=storage_path("sql\medien.sql");
    $file=\App\Helpers\Helper::parseSqlAddPrefix($file);
    \App\Helpers\Helper::chunkSql($file);
});

// * S t a t i c P a g e  s * //
Route::get('/{page}', App\Http\Controllers\SeitenController::class)->name('page');


