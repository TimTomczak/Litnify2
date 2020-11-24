<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seiten;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SystemController extends Controller
{
    public function index(){

       $info = '';

       return view('admin.systemverwaltung.index', compact(['info']));
    }

    public function auswertungen(){
        return view('admin.systemverwaltung.auswertungen');
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
        if($selection == '') {
            redirect()->route('admin.systemverwaltung.contenteditor', ['seite' => 'faq']);
        }
        $content = Seiten::getByTitle($selection);
        return view('admin.systemverwaltung.contenteditor', compact(['content', 'selection']));
    }

    public function contentEditorUpdate(Request $request){

        $validatedAttributes = $request->validate([
            'title' => 'required',
            'content' => 'required',
            ]);
        Seiten::create($validatedAttributes);

        return redirect(route('admin.systemverwaltung.contenteditor'));
    }

}
