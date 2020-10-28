<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function index(Request $request, $name, $action = 'view'){

       if($action == 'edit'){
           // Permission check
           // WYSIWYG Editor

           return view($name);

        }
        else{
            return view($name);
        }

    }




}
