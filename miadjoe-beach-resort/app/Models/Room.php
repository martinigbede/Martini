<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'room_type_id',
        'statut',
        'description',
        'prix_personnalise',
    ];

    protected $casts = [
        'prix_personnalise' => 'decimal:2',
    ];

    // Relation avec RoomType
    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }
    
    // Relation pour les photos (sera implémentée dans l'étape suivante pour RoomPhoto)
    public function photos()
    {
        return $this->hasMany(RoomPhoto::class);
    }

    public function images()
    {
        return $this->hasMany(\App\Models\RoomPhoto::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }

}