<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashAccount extends Model
{
    protected $fillable = [
        'nom_compte',
        'type_caisse',
        'solde',
    ];

    public function disbursements()
    {
        return $this->hasMany(Disbursement::class);
    }

    public function addTransaction($amount, $type, $description, $userId)
    {
        // Enregistrement de la transaction
        CashAccountTransaction::create([
            'cash_account_id' => $this->id,
            'montant' => $amount,
            'type_operation' => $type,     // 'entree' ou 'sortie'
            'motif' => $description,
            'user_id' => $userId,
        ]);

        // Mise à jour du solde
        if ($type === 'entree') {
            $this->increment('solde', $amount);
        } else {
            $this->decrement('solde', $amount);
        }
    }

}