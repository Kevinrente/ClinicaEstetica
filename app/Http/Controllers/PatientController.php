<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        // Validamos los datos
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:patients,email',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'occupation' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string',
            // Validamos los arrays JSON
            'medical_history' => 'nullable|array',
            'vip_preferences' => 'nullable|array',
        ]);

        // Creamos el paciente
        Patient::create($validated);

        return redirect()->route('dashboard')->with('success', '¡Paciente registrado con éxito!');
    }

    public function show(Patient $patient)
    {
        // 1. Cargar historial de citas con sus servicios y fichas
        $patient->load(['appointments.service', 'appointments.clinicalSheet', 'appointments.consent', 'appointments.photos']);

        // 2. Cargar sus packs activos (Billetera)
        $activePacks = \App\Models\PatientPackage::where('patient_id', $patient->id)
                        ->where('active', true)
                        ->with('service')
                        ->get();

        // 3. Cargar pagos realizados
        $payments = \App\Models\Payment::where('patient_id', $patient->id)
                        ->orderByDesc('created_at')
                        ->get();

        return view('patients.show', compact('patient', 'activePacks', 'payments'));
    }

    public function isBirthdayToday()
    {
        // Verifica si la fecha de hoy coincide con el día y mes de nacimiento
        return $this->birth_date && $this->birth_date->isBirthday();
    }

}