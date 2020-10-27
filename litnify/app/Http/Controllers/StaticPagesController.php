<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function index(Request $request, $name, $action = 'view'){

        if($action == 'edit'){
            $this->edit($name);
        }
        else{
            $this->view($name);
        }

    }

    public function view($name){

        return view($name);

    }

    public function edit($name){

        // Permission check
        // WYSIWYG Editor

        dd('edit');

    }


}
