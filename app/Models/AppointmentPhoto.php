<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AppointmentPhoto extends Model
{
    protected $fillable = ['appointment_id', 'path', 'type'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}