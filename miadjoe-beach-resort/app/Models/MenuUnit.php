<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuUnit extends Model
{
    //
    protected $fillable = ['menu_id', 'unit', 'price'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

}
