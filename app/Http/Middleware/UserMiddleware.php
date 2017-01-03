<?php

namespace App\Http\Middleware;

use Closure;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null){
			if (Auth::guard($guard)->check() && Auth::user()->type=='U'){
				return $next($request);
			}else{
				return redirect('/login');
			} 
    }
}
