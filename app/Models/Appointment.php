<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'service_id', 'user_id',
        'start_time', 'end_time',
        'status', 'internal_notes', 'payment_status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Relaciones
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Estas son las que causan el error en la carga del perfil:
    public function clinicalSheet()
    {
        return $this->hasOne(ClinicalSheet::class);
    }

    public function consent()
    {
        return $this->hasOne(Consent::class);
    }
    
    // Colores para el calendario
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'scheduled' => 'bg-blue-100 text-blue-800',
            'confirmed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'completed' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Relación: Una cita tiene muchas fotos
    public function photos()
    {
        return $this->hasMany(AppointmentPhoto::class);
    }

    // Método para consumir inventario
    public function consumeInventory()
    {
        // Obtenemos los productos asociados al servicio de esta cita
        // Asumiendo que el servicio tiene la relación 'products'
        foreach ($this->service->products as $product) {
            $qtyNeeded = $product->pivot->quantity;
            
            // Restamos del stock
            $product->decrement('stock', $qtyNeeded);
        }
    }
}