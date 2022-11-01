<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cliente
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
        if (auth()->user()->rol == "admin" || auth()->user()->rol == "empleado") {
            return response()->json([
                "status" => 401,
                "msg" => "Solo el cliente puede acceder a esto",
            ]);
        }else{
            return $next($request);
        }
    }
}
