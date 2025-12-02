<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiversServiceVenteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'divers_service_vente_id',
        'divers_service_id',
        'mode_facturation',
        'quantite',
        'duree',
        'prix_unitaire',
        'sous_total',
    ];

    public function vente()
    {
        return $this->belongsTo(DiversServiceVente::class);
    }

    public function service()
    {
        return $this->belongsTo(DiversService::class, 'divers_service_id');
    }
}
