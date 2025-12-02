<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    use HasFactory;
    
    protected $fillable = ['reservation_id', 'date', 'total'];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'sale_id');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'sale_id');
    }

    protected static function booted()
    {
        static::deleting(function ($sale) {
            // Supprimer la facture liée
            Invoice::where('sale_id', $sale->id)->delete();

            // Supprimer le paiement lié
            Payment::where('sale_id', $sale->id)->delete();
        });
    }    
}
