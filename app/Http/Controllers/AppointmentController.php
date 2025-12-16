<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        // Listamos citas futuras ordenadas por fecha
        $appointments = Appointment::with(['patient', 'service'])
                        ->where('start_time', '>=', now()->startOfDay())
                        ->orderBy('start_time')
                        ->get();
                        
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::orderBy('first_name')->get();
        $services = Service::where('active', true)->get();
        return view('appointments.create', compact('patients', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'service_id' => 'required|exists:services,id',
            'start_time' => 'required|date|after:now',
        ]);

        $service = Service::find($request->service_id);
        
        // Calculamos hora fin basándonos en si es pack o sesión simple
        // Por defecto asumimos 60 min si no hay dato, o usamos sessions_count como multiplicador si es pack
        $durationInMinutes = 60; 
        
        $startTime = Carbon::parse($request->start_time);
        $endTime = $startTime->copy()->addMinutes($durationInMinutes);

        Appointment::create([
            'patient_id' => $request->patient_id,
            'service_id' => $request->service_id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'user_id' => auth()->id(), // El usuario logueado crea la cita
            'internal_notes' => $request->internal_notes,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Cita agendada correctamente.');
    }

    // ... en AppointmentController.php

    public function startSession(Appointment $appointment)
    {
        // 1. Buscamos el tipo de ficha requerido por el servicio
        $sheetType = $appointment->service->sheet_type;

        if (!$sheetType) {
            return back()->with('error', 'El servicio no tiene asignado un tipo de ficha.');
        }

        // 2. Preparamos el nombre de la vista (ej. 'sheets.facial', 'sheets.corporal')
        $viewName = "sheets.{$sheetType}";

        // 3. Redirigimos al formulario específico
        try {
            return view($viewName, compact('appointment'));
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', "No existe el formulario {$viewName} aún.");
        }
    }

    public function attend(Appointment $appointment)
    {
        // Cargamos datos necesarios para la vista
        return view('appointments.attend', compact('appointment'));
    }
}