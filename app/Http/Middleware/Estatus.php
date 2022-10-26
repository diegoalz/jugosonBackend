<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Closure;

class Estatus
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
        if (isset($request->email)) {
            $user = User::where("email", "=", $request->email)->first();
            if ($user->estatus == true) {
                return $next($request);
            }else{
                return response()->json([
                    "status" => 401,
                    "msg" => "Cuenta dada de baja",
                ]);
            }
        }
    }
}
