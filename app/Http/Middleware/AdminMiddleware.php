<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan memiliki role admin (id_role = 1)
        if (!auth()->check() || auth()->user()->id_role != 1) {
            abort(403, 'Akses hanya untuk admin');
        }

        return $next($request);
    }
}
