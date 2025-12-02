<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashAccountTransaction extends Model
{
    use HasFactory;

    protected $table = 'cash_account_transactions';

    protected $fillable = [
        'cash_account_id',
        'montant',
        'type_operation',
        'motif',
        'user_id',
    ];

    // Relation vers le compte de caisse
    public function cashAccount()
    {
        return $this->belongsTo(CashAccount::class);
    }

    // Relation vers l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Retourne le montant signé selon le type
    public function getMontantSigneAttribute()
    {
        return $this->type_operation === 'entree'
            ? $this->montant
            : -$this->montant;
    }
}
