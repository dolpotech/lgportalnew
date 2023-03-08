<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Authkey
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
        $token=$request->header('APP_KEY');
        if($token != '987654321@$#'){
            return response()->json(["message"=>'App key not found'], 401);
        }
        return $next($request);

    }
}
