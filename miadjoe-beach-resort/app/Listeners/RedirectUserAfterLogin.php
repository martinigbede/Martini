<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

class RedirectUserAfterLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;

        // Redirection selon rôle
        if ($user->hasRole('Direction')) {
            session(['intended_url' => route('dashboard.direction')]);
        } elseif ($user->hasRole('Comptable')) {
            session(['intended_url' => route('dashboard.comptable')]);
        } elseif ($user->hasRole('Réception')) {
            session(['intended_url' => route('dashboard.reception')]);
        } elseif ($user->hasRole('Restauration')) {
            session(['intended_url' => route('dashboard.restauration')]);
        }
        // Par défaut
        else {
            session(['intended_url' => route('home')]);
        }
    }
}
