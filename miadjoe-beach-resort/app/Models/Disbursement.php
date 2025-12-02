<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disbursement extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'montant',
        'user_id', // utilisateur qui a fait le décaissement
        'est_encaisse', // booléen pour indiquer si le décaissement a été encaissé
        'encaisse_user_id', // utilisateur qui a encaissé le décaissement
        'cash_account_id', // compte de caisse utilisé pour l'encaissement
        'encaisse_at',
        'motif',
    ];

    public function encaisseur()
    {
        return $this->belongsTo(User::class, 'encaisse_user_id');
    }

    // Relation vers la réservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    // Relation vers l'utilisateur qui a fait le décaissement
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cashAccount()
    {
        return $this->belongsTo(CashAccount::class);
    }
    
}
