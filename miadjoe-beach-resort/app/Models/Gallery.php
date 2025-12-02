<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Gallery extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'type'];

    public function items()
    {
        return $this->hasMany(GalleryItem::class)->orderBy('order_index', 'asc');
    }
}