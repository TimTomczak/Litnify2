<?php

namespace App\Http\Middleware;

use App\Helpers\TableBuilder;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogActions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $log=Auth::user()->uid; //UID
        $aktion=explode('@',$request->route()->action['controller'])[1];    //Aktion z.B. 'update', 'store', 'destroy'
        if (array_key_exists($aktion,TableBuilder::$logAktionen)){
            if (isset($request->route()->parameterNames()[0])&&count($request->route()->parameterNames())==1){
                $objekt=$request->route()->parameterNames()[0];
                $log.=' '.ucfirst($objekt); //Objekt z.B. 'Medium', 'Zeitschrift', 'User'
                $log.=' '.$request->route()->parameters()[$objekt]->id; //ID des Objektes
            }else{
                $controller_exploded=explode('\\',$request->route()->action['controller']);
                $controller_action=$controller_exploded[count($controller_exploded)-1];
                $objekt=str_replace('Controller','',explode('@',$controller_action)[0]);
                $log.=' '.$objekt;
                if ($objekt=='Ausleihe'){   //falls Ausleihe
                    $user=$request->route()->originalParameter('user');
                    $medium=$request->route()->originalParameter('medium');
                    $log.=' '.$user.'->'.$medium; //Nutzer->ausgeliehenes Medium
                }else{
                    $log.=' -';
                }
            }
            $log.=' '.$aktion;
            Log::channel('actions')->info($log);
        }

        return $next($request);
    }
}
