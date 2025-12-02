<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'categorie',
        'description',
        'montant',
        'date_depense',
        'mode_paiement',
        'payment_id',
        'statut',
    ];

    protected $casts = [
        'date_depense' => 'date',
        'montant' => 'decimal:2',
    ];

    /**
     * L'utilisateur (caissier ou comptable) qui a créé la dépense.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Paiement associé, s’il y en a un (ex : retrait caisse, virement...).
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Retourne un libellé coloré du statut pour l'affichage.
     */
    public function getStatutBadgeAttribute()
    {
        return match ($this->statut) {
            'validée' => '<span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">Validée</span>',
            'en attente' => '<span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-semibold">En attente</span>',
            default => '<span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold">Inconnu</span>',
        };
    }
}
