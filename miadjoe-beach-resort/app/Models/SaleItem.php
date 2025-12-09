<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'sale_id',
        'menu_id',
        'quantite',
        'prix_unitaire',
        'total',
        'unite',
        'remise_type',
        'remise_valeur',
        'est_offert',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
