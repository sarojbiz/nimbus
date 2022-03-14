<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminPermission
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
        if (Auth::guard('admin')->check()) {
            if( Auth::guard('admin')->user()->user_type == 1 ){
                return $next($request);
            }else{
                return redirect()->route('admin')->with('flash_error', 'Access denied');
            }
        }else{
            return redirect()->route('admin')->with('flash_error', 'Access denied');
        }
       
    }
}