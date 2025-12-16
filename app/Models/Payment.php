<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['appointment_id', 'patient_id', 'amount', 'method', 'concept'];
    
    public function patient() { return $this->belongsTo(Patient::class); }
}
