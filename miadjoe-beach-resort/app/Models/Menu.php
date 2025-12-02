<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    use HasFactory;
    protected $fillable = ['nom',  'prix', 'disponibilite', 'category_id', 'photo'];
    protected $casts = ['prix' => 'decimal:2'];
    
    public function sales() { return $this->hasMany(Sale::class); }
    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'category_id');
    }

    public function units()
    {
        return $this->hasMany(MenuUnit::class);
    }
}
