<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  int  $roleId
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, int $roleId)
    {
        if (Auth::check() && Auth::user()->id_role === $roleId) {
            return $next($request);
        }

        // Jika peran tidak sesuai, redirect atau tampilkan pesan error
        return redirect()->route('index')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
