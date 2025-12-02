<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'reservation_id',
        'divers_service_vente_id',
        'montant_total',
        'montant_paye',
        'remise_percent',
        'remise_amount',
        'montant_final',
        'statut',
    ];

    public function sale()
    {
        return $this->belongsTo(\App\Models\Sale::class);
    }

    public function reservation()
    {
        return $this->belongsTo(\App\Models\Reservation::class);
    }

    public function diversServiceVente()
    {
        return $this->belongsTo(\App\Models\DiversServiceVente::class);
    }

    // 🔹 Relation vers les paiements en fonction du type de facture
    public function payments()
    {
        if ($this->sale_id) {
            return $this->hasMany(\App\Models\Payment::class, 'sale_id', 'sale_id');
        }

        if ($this->reservation_id) {
            return $this->hasMany(\App\Models\Payment::class, 'reservation_id', 'reservation_id');
        }

        // Facture vide si pas de lien
        return $this->hasMany(\App\Models\Payment::class)->whereRaw('1=0');
    }

    protected static function booted()
    {
        static::updated(function ($invoice) {

            if ($invoice->statut === 'Payée' && $invoice->sale_id) {

                $sale = $invoice->sale;

                if ($sale && $sale->statut !== 'Payé') {
                    $sale->update(['statut' => 'Payé']);
                }
                
            }
             
            if ($invoice->statut === 'Payée' && $invoice->divers_service_vente_id) {
                $diversService = $invoice->diversServiceVente;
                if ($diversService && $diversService->statut !== 'Payé') {
                    $diversService->update(['statut' => 'Payé']);
                }
            }
        });
    }
}
