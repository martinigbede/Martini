<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        // 🔐 Redirection selon le rôle
        if ($user->hasRole('Direction')) {
            return redirect()->intended('/dashboard/direction');
        }

        if ($user->hasRole('Comptable')) {
            return redirect()->intended('/dashboard/comptable');
        }

        if ($user->hasRole('Réception')) {
            return redirect()->intended('/dashboard/reception');
        }

        if ($user->hasRole('Restauration')) {
            return redirect()->intended('/dashboard/restauration');
        }
        if ($user->hasRole('Caisse')) {
            return redirect()->intended('/dashboard/caisse');
        }

        // Par défaut (si aucun rôle)
        return redirect()->intended(route('home'));
    }
}
