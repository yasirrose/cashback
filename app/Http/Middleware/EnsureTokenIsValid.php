<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Auth;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(isset($_COOKIE['secret'])){
            $request->headers->set('Accept', 'application/json');
            $request->headers->set('Authorization', 'Bearer '.$_COOKIE['secret'] );
            if(Auth::guard('api')->check()){
                return $next($request);
            }else{
                return redirect('/login');
            }
        }else{
            return redirect('/login');
        }
        
    }
}
