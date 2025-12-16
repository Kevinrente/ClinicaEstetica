<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function store(Request $request, Appointment $appointment)
    {
        $request->validate([
            'photo' => 'required|image|max:10240', // Max 10MB
            'type' => 'required|in:before,after',
        ]);

        // 1. Guardar archivo en disco 'public'
        // Se guardará en: storage/app/public/photos/{appointment_id}
        $path = $request->file('photo')->store("photos/{$appointment->id}", 'public');

        // 2. Registrar en BD
        AppointmentPhoto::create([
            'appointment_id' => $appointment->id,
            'path' => $path,
            'type' => $request->type,
        ]);

        return back()->with('success', 'Foto subida correctamente.');
    }
}