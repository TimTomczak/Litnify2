<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Checkrole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission_id)
    {
        if($request->user()->berechtigungsrolle_id < $permission_id){
            abort('403', 'Zugriff verweigert');
        }
        return $next($request);
    }
}
