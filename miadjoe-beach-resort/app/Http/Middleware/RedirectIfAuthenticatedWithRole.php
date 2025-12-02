<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedWithRole
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Redirection selon rôle
            if ($user->hasRole('Direction')) {
                return redirect()->route('dashboard.direction');
            }

            if ($user->hasRole('Comptable')) {
                return redirect()->route('dashboard.comptable');
            }

            if ($user->hasRole('Réception')) {
                return redirect()->route('dashboard.reception');
            }

            if ($user->hasRole('Restauration')) {
                return redirect()->route('dashboard.restauration');
            }
            if ($user->hasRole('Caisse')) {
                return redirect()->route('dashboard.caisse');
            }

            // Par défaut
            return redirect()->route('home');
        }

        return $next($request);
    }
}
