<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientPackage extends Model
{
    protected $fillable = ['patient_id', 'service_id', 'total_sessions', 'remaining_sessions', 'price_paid', 'active'];

    public function service() { return $this->belongsTo(Service::class); }
}
