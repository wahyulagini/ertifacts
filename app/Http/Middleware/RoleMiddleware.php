<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Usage di routes: middleware('role:admin')
     *                  middleware('role:tenant')
     *                  middleware('role:pengunjung')
     */
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!in_array(Auth::user()->role, $roles)) {
            // Kalau role tidak sesuai, kirim ke dashboard yang tepat
            return match(Auth::user()->role) {
                'admin'  => redirect()->route('admin.dashboard'),
                'tenant'  => redirect()->route('tenant.dashboard'),
                default  => redirect()->route('pengunjung.dashboard'),
            };
        }

        return $next($request);
    }
}
