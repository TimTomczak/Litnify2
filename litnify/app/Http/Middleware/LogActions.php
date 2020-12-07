<?php

namespace App\Http\Middleware;

use App\Helpers\Helper;
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
        $additionalData=[
            'user'=>Auth::user(),
            'aktion'=>$request->route()->getActionName(),
            'parameter'=>$request->route()->parameters()
        ];

        // Logging in Form "uid: /der/aufgerufene/pfad {JSON additionalData}"
        Log::channel('actions')
            ->info(Auth::user()->uid.': '.$request->decodedPath().' ',$additionalData);
        return $next($request);
    }
}
