<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Reservation extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'client_id',
        'room_id',
        'check_in',
        'check_out',
        'nb_personnes',
        'lit_dappoint',
        'statut',
        'total',
    ];

    // **** AJOUTER CETTE MÉTHODE ****
    public function client()
    {
        // Assurez-vous que le modèle Client est dans App\Models\Client
        return $this->belongsTo(Client::class, 'client_id');
    }

    // Relation vers Room
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'reservation_room');
    }

    // Relations vers Paiement/Facture (à ajouter si non fait)
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function invoices() { return $this->hasMany(Invoice::class); }

    // Relation pour obtenir le montant total payé
    public function totalPaid()
    {
        return $this->payments()->where('statut', 'Payé')->sum('montant');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    public function items()
    {
        return $this->hasMany(ReservationItem::class);
    }

    public function disbursements()
    {
        return $this->hasMany(Disbursement::class);
    }

    public function recalculerTotal()
    {
        // Total de base (hébergement)
        $totalHebergement = $this->getOriginal('total'); // ⚡ ON NE MODIFIE PLUS ÇA

        // Total des ventes liées
        $totalVentes = $this->sales()->sum('total');

        // Nouveau total combiné (affiché)
        $totalGeneral = $totalHebergement + $totalVentes;

        // ❗ On NE met plus à jour le champ 'total' car il représente l’hébergement
        // On met à jour UNIQUEMENT la facture
        if ($this->invoice) {
            // 🛑 SI facture offerte → montant_final doit toujours rester 0
            if ($this->invoice->statut === 'Offerte') {
                $this->invoice->update([
                    'montant_total' => $totalGeneral,
                    'remise_amount' => $totalGeneral,
                    'remise_percent' => 100,
                    'montant_final' => 0,
                    'montant_paye' => 0,
                ]);
                return $totalGeneral;
            }

            // Sinon, fonctionnement normal
            $this->invoice->update([
                'montant_total' => $totalGeneral,
                'montant_final' => $totalGeneral - $this->invoice->remise_amount,
            ]);
        }

        return $totalGeneral;
    }

    public function verifierConfirmationAutomatique(): void
    {
        // Total payé (somme de tous les paiements liés)
        $totalPaye = $this->payments()->sum('montant');

        // Si le total existe (pas nul) et qu’au moins 50% est payé
        if ($this->total > 0 && $totalPaye >= ($this->total * 0.5)) {
            if ($this->statut !== 'Confirmée') {
                $this->statut = 'Confirmée';
                $this->saveQuietly(); // ✅ évite la boucle d'événements
            }
        }
    }

}
