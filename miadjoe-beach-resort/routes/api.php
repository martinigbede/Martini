<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SemoaCallbackController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route par défaut (exemple)
/*
|--------------------------------------------------------------------------
| ROUTE CRITIQUE DE CALLBACK SEMOA (WEBHOOK)
|--------------------------------------------------------------------------
| Le service de paiement (SEMOA) envoie une notification POST à cette URL
| pour informer l'application du statut final (Succès/Échec) d'une transaction.
| C'est le point d'entrée qui met à jour la base de données.

Route::post('/semoa/callback', [SemoaCallbackController::class, 'handle'])
    ->name('api.semoa.callback'); // Nommer la route est facultatif, mais recommandé.
*/

Route::post('/semoa/callback', [SemoaCallbackController::class, 'handle'])->name('semoa.callback');

