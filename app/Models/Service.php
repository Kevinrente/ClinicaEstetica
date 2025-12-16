<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // Campos que permitimos llenar masivamente
    protected $fillable = [
        'name',
        'category',
        'description',
        'price_type',
        'price',
        'max_price',
        'sessions_count',
        'includes_services',
        'protocol_steps',
        'contraindications',
        'requires_consent',
        'legal_text',
        'duration',
        'active',
    ];

    // CASTING: Esto convierte el JSON de Postgres a Array de PHP automáticamente
    protected $casts = [
        'includes_services' => 'array',
        'protocol_steps' => 'array',
        'contraindications' => 'array',
        'requires_consent' => 'boolean',
        'active' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Helper para saber si el precio es variable
     */
    public function isVariablePrice(): bool
    {
        return $this->price_type !== 'FIXED';
    }

    /**
     * Helper para mostrar el precio formateado en la vista
     * Ej: "$20.00 - $30.00" o "$45.00"
     */
    public function getFormattedPriceAttribute(): string
    {
        if ($this->price_type === 'RANGE' && $this->max_price) {
            return '$' . number_format($this->price, 2) . ' - $' . number_format($this->max_price, 2);
        }
        
        if ($this->price_type === 'FROM') {
            return 'Desde $' . number_format($this->price, 2);
        }

        return '$' . number_format($this->price, 2);
    }

    // Relación: Un servicio consume muchos productos
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}