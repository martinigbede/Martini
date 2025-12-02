<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sale_id',
        'reservation_id',
        'divers_service_vente_id',
        'transaction_id',
        'montant',
        'mode_paiement',
        'is_remise',
        'remise_percent',
        'remise_amount',
        'motif_remise',
        'est_offert',
        'statut',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    protected static function booted()
    {
        static::saved(function ($payment) {
            if ($payment->reservation) {
                $payment->reservation->verifierConfirmationAutomatique();
            }
        });
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function diversServiceVente()
    {
        return $this->belongsTo(DiversServiceVente::class);
    }

}
