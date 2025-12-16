<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 
        'birth_date', 'occupation', 
        'emergency_contact_name', 'emergency_contact_phone',
        'medical_history', 'vip_preferences'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'medical_history' => 'array',
        'vip_preferences' => 'array',
    ];

    // --- RELACIONES ---
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function packages()
    {
        return $this->hasMany(PatientPackage::class);
    }

    // --- ACCESSORS Y HELPERS ---

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAgeAttribute()
    {
        return $this->birth_date ? $this->birth_date->age : 'N/A';
    }
    
    // ESTA ES LA FUNCIÓN QUE FALTABA Y CAUSABA EL ERROR BAD METHOD CALL
    public function isBirthdayToday()
    {
        if (!$this->birth_date) return false;
        return $this->birth_date->isBirthday();
    }
}