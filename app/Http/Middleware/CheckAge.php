<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //logic of middleware

        $age = Auth::user() -> age;

        if ($age < 15) {
            //return redirect() -> back();
            return redirect() -> route('home');
        } else {
            return $next($request);
            // return redirect() -> route('adult');
        }
    }
}
