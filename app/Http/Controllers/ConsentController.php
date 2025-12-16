<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Consent;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ConsentController extends Controller
{
    // Pantalla para firmar
    public function create(Appointment $appointment)
    {
        return view('consents.create', compact('appointment'));
    }

    // Guardar firma y descargar PDF
    public function store(Request $request, Appointment $appointment)
    {
        $request->validate([
            'signature' => 'required', // String base64
        ]);

        // 1. Guardar en Base de Datos
        $consent = Consent::create([
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'signature_data' => $request->signature,
            'legal_text_snapshot' => $appointment->service->legal_text ?? 'Texto genérico aplicado...',        ]);

        // 2. Actualizar la cita (opcional, para marcar que ya firmó)
        // $appointment->update(['consent_signed' => true]); 

        // 3. Generar el PDF
        $pdf = Pdf::loadView('consents.pdf', [
            'appointment' => $appointment,
            'signature' => $request->signature,
            'date' => now()->format('d/m/Y H:i'),
        ]);

        // Descargar o mostrar en navegador
        return $pdf->stream('Consentimiento_' . $appointment->patient->last_name . '.pdf');
    }
}