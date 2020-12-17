<?php

namespace App\Http\Controllers;

use App\Models\Auswertung;
use App\Models\Seiten;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class SystemController extends Controller
{
    public function index(){
       $info = '';
       return view('admin.systemverwaltung.index', compact(['info']));
    }

    public function auswertungen(){

        return view('admin.systemverwaltung.auswertungen',[
            'top_ausleihen' => Auswertung::getTopAusleihen(),
            'ausleihen_offen' => Auswertung::getAusleihenOffen(),
        ]);
    }

    public function logs(Request $request){
        $date = new Carbon($request->get('date', today()));
        $filePath = storage_path("logs/laravel-{$date->format('Y-m-d')}.log");
        $data = [];
        if(File::exists($filePath)){
            $data = [
                'lastModified' => new Carbon(File::lastModified($filePath)),
                'size' => File::size($filePath),
                'file' => File::get($filePath),
            ];
        }
        return view('admin.systemverwaltung.logs', compact(['date', 'data']));
    }

    public function contentEditor(Request $request){
        $selection = $request->seite;
        if(is_null($selection)) {
            return redirect()->route('admin.systemverwaltung.contenteditor', ['seite' => 'faq']);
        }
        $tabs = Seiten::all()->unique('title')->pluck('title');
        $content = Seiten::where('title', $selection)->latest('created_at')->value('content');

        if (is_null($content)){
            abort('403', 'Seite existiert nicht');
        }
        return view('admin.systemverwaltung.contenteditor', compact(['content', 'selection', 'tabs']));
    }

    public function contentEditorUpdate(Request $request){
        Seiten::create($request->validate([
            'title' => 'required',
            'content' => 'required',
        ]));
        return redirect(route('admin.systemverwaltung.contenteditor'));
    }

    public function command(Request $request){
        Artisan::command('cache:clear');
        Artisan::command('view:clear');
        Artisan::command('routes:clear');
        Artisan::command('config:clear');
    }

    public function storeImage($name, $file){

        /* @todo validation
        $this->validate($file, [
            'mimeType' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        dd($file);
        */
        $file->storeAs('storage/images', $name);
        return redirect(route('admin.systemverwaltung.contenteditor'));
    }

    public function updateLogo(Request $request){

        if($request->has('logo')){
            $this->storeImage('logo.png', $request->logo);
        }
        elseif($request->has('sublogo')){
            $this->storeImage('sublogo.png', $request->sublogo);
        }
        else{
            Redirect::back()->withErrors(
                ['error' => 'Es wurde keine Datei übermittelt.']
            );
        };
    }
}
