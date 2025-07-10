<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectToRoleDashboard
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Solo si está logueado y viene a /admin o /dashboard
        if ($request->is('admin') || $request->is('dashboard')) {
            if ($user->rol === 'director') {
                return redirect()->route('filament.admin.pages.dashboard-general');
            } elseif ($user->rol === 'docente') {
                return redirect()->route('filament.admin.pages.dashboard-docente');
            }
        }

        return $next($request);
    }
}
