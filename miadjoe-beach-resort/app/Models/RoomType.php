<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{

    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'prix_base',
        'nombre_personnes_max',
        'photo',
    ];

    protected $casts = [
        'prix_base' => 'decimal:2',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    
}
