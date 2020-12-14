<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockedUser
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
        if (\Auth::check()) {
            if ($request->user()->deleted == 1) {
                \Auth::logout();
                return redirect('login')->with([
                    'title' => 'Deaktivert ',
                    'message' => 'Ihr Account wurde deaktiviert. Sie wurden automatisch ausgeloggt!',
                    'alertType' => 'danger',
                    'duration' => 10000
                ]);
            } else {
                return $next($request);
            }
        }
        else {
            return $next($request);
        }
    }
}
