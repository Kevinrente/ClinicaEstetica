<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    // Muestra el formulario de reserva (Paso 1)
    public function create()
    {
        // Traemos solo los servicios activos, ordenados por nombre
        $services = Service::orderBy('name')->get();
        return view('booking.create', compact('services'));
    }

    // Guarda la reserva (Paso 2)
    public function store(Request $request)
    {
        // 1. Validamos los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:today', // No pueden reservar en el pasado
            'appointment_time' => 'required',
        ]);

        // 2. Buscamos al paciente o lo creamos (Logica "First or Create")
        // Buscamos por teléfono, que es lo más único
        $patient = Patient::firstOrCreate(
            ['phone' => $request->phone], 
            [
                'first_name' => $request->name,
                'last_name' => '(Web)', // Apellido temporal si solo ponen un nombre
                'email' => $request->email,
            ]
        );

        // Si el paciente ya existía pero puso otro nombre, actualizamos opcionalmente
        if ($request->name) {
            // Un pequeño hack para separar nombre y apellido si el usuario puso "Maria Perez"
            $parts = explode(' ', $request->name, 2);
            $patient->first_name = $parts[0];
            $patient->last_name = $parts[1] ?? '(Web)';
            $patient->save();
        }

        // 3. Asignamos una esteticista (Por ahora asignamos al primer usuario del sistema, luego podemos hacerlo aleatorio)
        $defaultStaff = User::first(); 

        // 4. Creamos la Cita
        $fechaHora = Carbon::parse($request->appointment_date . ' ' . $request->appointment_time);

        Appointment::create([
            'patient_id' => $patient->id,
            'user_id' => $defaultStaff->id, // Asignado a la dueña por defecto
            'service_id' => $request->service_id,
            'start_time' => $fechaHora,
            'end_time' => $fechaHora->copy()->addMinutes(60), // Duración base (luego lo mejoraremos con la duración real del servicio)
            'status' => 'scheduled',
            'notes' => 'Reserva online automática.',
        ]);

        return redirect()->route('booking.success');
    }

    public function success()
    {
        return view('booking.success');
    }
}