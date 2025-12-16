<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consent extends Model
{
    use HasFactory;

    // ESTA FUE LA PARTE QUE FALTABA:
    protected $fillable = [
        'appointment_id',
        'patient_id',
        'signature_data',
        'legal_text_snapshot',
    ];

    // Relaciones
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}