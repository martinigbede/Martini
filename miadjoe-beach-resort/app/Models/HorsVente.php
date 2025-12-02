<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorsVente extends Model
{
    protected $fillable = [
        'montant',
        'mode_paiement',
        'motif',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
