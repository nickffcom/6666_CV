<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleWare
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
        $userRequest = Auth::user();
        if(!isset($userRequest)){
            return redirect('/login');
        }
        if($userRequest->is_admin === IS_ADMIN || $userRequest->role === ROLE_ADMIN){
            return $next($request);
        }
        return redirect('/');
    }
}
