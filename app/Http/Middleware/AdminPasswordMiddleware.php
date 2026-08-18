<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPasswordMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika session 'admin_authenticated' TIDAK ADA / FALSE, tendang ke login
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login.form');
        }

        return $next($request);
    }
}