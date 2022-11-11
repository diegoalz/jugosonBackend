<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Usuario
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
        if ((auth()->user()->rol == "admin") || (auth()->user()->rol == "empleado")) {
            return $next($request);
        }else{
            return response()->json([
                "status" => 401,
                "msg" => "Permiso denegado",
            ]);
        }
    }
}
