<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiversServiceVente extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_nom', 'type_client', 'user_id', 'total', 'remarque'
    ];

    public function items()
    {
        return $this->hasMany(DiversServiceVenteItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'divers_service_vente_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'divers_service_vente_id');
    }

    public function service()
    {
        return $this->belongsTo(DiversService::class);
    }

    protected static function booted()
    {
        static::deleting(function ($vente) {
            // Supprime la facture liée
            if ($vente->invoice) {
                $vente->invoice->delete();
            }
        });
    }
    
}
