<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\SemoaCallbackController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AvailableRoomsController;
//use App\Http\Controllers\PaiementController; // si utilisé
// … avoir tous les contrôleurs nécessaires

/*
|--------------------------------------------------------------------------
| Routes publiques (sans authentification)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::view('/about', 'public.about')->name('public.about');
Route::view('/menu', 'public.menu')->name('public.menu');
Route::view('/gallery', 'public.gallery')->name('public.gallery');
Route::view('/contact', 'public.contact')->name('public.contact');
Route::view('/rooms', 'public.rooms')->name('public.rooms');
Route::view('/condition', 'public.condition-general')->name('public.condition');
Route::get('/select-room', function () {
    return view('public.select-room');
})->name('public.select-room');

Route::get('/rooms/available', [AvailableRoomsController::class, 'index'])->name('rooms.available');
Route::get('/reservation', function () {
    return view('public.reservation');
})->name('public.reservation');

/*
|--------------------------------------------------------------------------
| Routes de paiement (publique / client)
|--------------------------------------------------------------------------
*/
// Route pour lancer le paiement via SEMOA
Route::get('/paiement/{reservation}/payer', [SemoaCallbackController::class, 'payer'])->name('semoa.payer');

// Routes de redirection après paiement
Route::get('/paiement/success', [SemoaCallbackController::class, 'success'])->name('semoa.success');
Route::get('/paiement/cancel', [SemoaCallbackController::class, 'cancel'])->name('semoa.cancel');

// Callback webhook SEMOA (POST)
//Route::post('/api/semoa/callback', [SemoaCallbackController::class, 'handle'])->name('semoa.callback');

/*
|--------------------------------------------------------------------------
| Routes internes authentifiées (dashboard, etc.)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Dashboard selon rôle
    Route::middleware(['role:Direction'])->group(function () {
        Route::view('/dashboard/direction', 'dashboard.direction')->name('dashboard.direction');
        Route::get('/dashboard/direction/settings', function () {
            return view('dashboard.direction.settings');
        })->name('dashboard.direction.settings');
        Route::get('/dashboard/direction/users', function () {
            return view('dashboard.direction.users');
        })->name('dashboard.direction.users');
        Route::get('/dashboard/direction/messages', function () {
            return view('dashboard.direction.messages');
        })->name('dashboard.direction.messages');
        Route::get('/dashboard/direction/divers-services', function () {
            return view('dashboard.direction.divers-services');
        })->name('dashboard.directions.divers-services');
    });

    // Comptable
    Route::middleware(['role:Comptable'])->group(function () {
        Route::view('/dashboard/comptable', 'dashboard.comptable')->name('dashboard.comptable');
        
    });

    // Caisse
    Route::middleware(['role:Caisse|Comptable|Restauration'])->group(function () {
        Route::view('/dashboard/caisse', 'dashboard.caisse')->name('dashboard.caisse');
        Route::get('/dashboard/comptable/historique', function () {
            return view('dashboard.comptable.historique');
        })->name('dashboard.comptable.historique');
        Route::get('/dashboard/caisse/depenses', function () {
            return view('dashboard.caisse.depenses');
        })->name('dashboard.caisse.depenses');
    });

    // Réception / Restauration / etc.
    Route::middleware(['role:Réception|Direction'])->group(function () {
        Route::view('/dashboard/reception', 'dashboard.reception')->name('dashboard.reception');
    });
    Route::middleware(['role:Restauration|Direction'])->group(function () {
        Route::view('/dashboard/restauration', 'dashboard.restauration')->name('dashboard.restauration');
    });
    

    // Gestion (Direction | Réception) chambres/types/reservations etc.
    Route::middleware(['role:Direction|Réception'])->group(function () {
        Route::get('/dashboard/gestion/room-types', function () {
            return view('dashboard.gestion.room-types');
        })->name('dashboard.gestion.room-types');
        Route::get('/dashboard/gestion/rooms', function () {
            return view('dashboard.gestion.rooms');
        })->name('dashboard.gestion.rooms');
        Route::get('/dashboard/gestion/reservations', function () {
            return view('dashboard.gestion.reservations');
        })->name('dashboard.gestion.reservations');
        Route::get('/dashboard/gestion/clients', function () {
            return view('dashboard.gestion.clients');
        })->name('dashboard.gestion.clients');
        Route::get('/dashboard/gestion/calendar', function () {
            return view('dashboard.gestion.calendar');
        })->name('dashboard.gestion.calendar');
        Route::get('/dashboard/direction/divers-services', function () {
            return view('dashboard.direction.divers-services');
        })->name('dashboard.directions.divers-services');
        Route::get('/dashboard/gestion/caisse-hebergement', function () {
            return view('dashboard.gestion.caisse-hebergement');
        })->name('dashboard.gestion.caisse-hebergement');
        Route::get('/dashboard/gestion/decaissement', function () {
            return view('dashboard.gestion.decaissement');
        })->name('dashboard.gestion.decaissement');
    });

    // Vente & menu (Restauration | Direction)
    Route::middleware(['role:Restauration|Direction'])->group(function () {
        Route::get('/dashboard/gestion/menus', function () {
            return view('dashboard.gestion.menus');
        })->name('dashboard.gestion.menus');
        Route::get('/dashboard/gestion/sales', function () {
            return view('dashboard.gestion.sales');
        })->name('dashboard.gestion.sales');
    });

    // Gestion des ventes de services divers (Direction | Réception | Restauration)
    Route::middleware(['role:Direction|Réception|Restauration'])->group(function () {
        Route::get('/dashboard/gestion/vente-services', function () {
            return view('dashboard.gestion.vente-services');
        })->name('dashboard.gestion.vente-services');
        Route::get('/dashboard/gestion/caisse-restaurant', function () {
            return view('dashboard.gestion.caisse-restaurant');
        })->name('dashboard.gestion.caisse-restaurant');
    });


    // Galerie (gestion)
    Route::middleware(['role:Restauration|Direction|Réception|Comptable'])->group(function () {
        Route::get('/dashboard/gestion/gallery', function () {
            return view('dashboard.gestion.gallery');
        })->name('dashboard.gestion.gallery');
    });
});

// Téléchargement de facture
Route::get('/factures/{id}/download', [InvoiceController::class, 'download'])->name('invoice.download');
Route::get('/rooms/{room}', [\App\Http\Controllers\PublicRoomController::class, 'show'])
     ->name('rooms.show');
use App\Http\Controllers\PublicBookingController;
Route::get('/reservation/public-booking', [PublicBookingController::class, 'index'])
     ->name('reservation.public-booking-form');

// Pour Livewire v3
use Livewire\Livewire;


