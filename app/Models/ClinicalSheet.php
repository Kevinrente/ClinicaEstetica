<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'sheet_type',
        'sheet_data',
        'final_notes',
        'consent_signed',
    ];

    protected $casts = [
        'sheet_data' => 'array',
        'consent_signed' => 'boolean',
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