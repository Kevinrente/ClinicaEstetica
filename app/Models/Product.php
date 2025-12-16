<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sku', 'stock', 'min_stock', 'unit', 'cost'];

    // Relación con servicios (Muchos a Muchos)
    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot('quantity');
    }
}