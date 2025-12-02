<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationItem extends Model
{
    use HasFactory;

    protected $table = 'reservation_items';

    protected $fillable = [
        'reservation_id',
        'room_id',
        'quantite',
        'nb_personnes',
        'lit_dappoint',
        'prix_unitaire',
        'total',
    ];

    protected $casts = [
        'lit_dappoint' => 'boolean',
        'prix_unitaire' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * 🔗 Relation vers la réservation principale
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * 🔗 Relation vers la chambre concernée
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * 🔹 Calcule le total de cet item en fonction du prix unitaire et de la quantité
     */
    public function calculateTotal(): float
    {
        $this->total = ($this->prix_unitaire * $this->quantite);
        return $this->total;
    }

    /**
     * 🔹 Met à jour le prix unitaire à partir du type de chambre et du calculateur central
     */
    public function updatePricing(int $days)
    {
        if (!$this->room || !$this->room->roomType) {
            return;
        }

        $this->prix_unitaire = \App\Services\ReservationCalculator::calculateTotal(
            $this->room->roomType->id,
            $this->lit_dappoint,
            $this->nb_personnes,
            $days
        );

        $this->calculateTotal();
    }
}
