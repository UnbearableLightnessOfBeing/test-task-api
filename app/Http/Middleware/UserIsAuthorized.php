<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsAuthorized
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

        //User is considered authorized only if the http header has a heading "User-Id" with a respective user id value
        if((int) $request->header('User-Id') == (int) $request->user->id) {
            return $next($request);
        }else {
            return response()->json([
                'message' => 'User is unauthorized'
            ],401);
        }

        
    }
}
