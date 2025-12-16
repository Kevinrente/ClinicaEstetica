<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use App\Models\PatientPackage;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    // Muestra la pantalla de cobro
    public function show(Appointment $appointment)
    {
        // 1. Buscamos si el paciente tiene un pack ACTIVO para este servicio
        $activePackage = PatientPackage::where('patient_id', $appointment->patient_id)
                                        ->where('service_id', $appointment->service_id)
                                        ->where('remaining_sessions', '>', 0)
                                        ->where('active', true)
                                        ->first();

        return view('checkout.show', compact('appointment', 'activePackage'));
    }

    // Procesa el pago
    public function process(Request $request, Appointment $appointment)
    {
        $successMessage = '';

        // --- BLOQUE 1: PROCESAMIENTO DEL PAGO ---
        
        // Opción A: Usar una sesión de un Pack existente
        if ($request->payment_method === 'pack') {
            $package = PatientPackage::findOrFail($request->package_id);
            
            // Descontamos 1 sesión
            $package->decrement('remaining_sessions');
            
            // Registramos el "Pago" con costo 0 (simbólico) para historial
            Payment::create([
                'appointment_id' => $appointment->id,
                'patient_id' => $appointment->patient_id,
                'amount' => 0,
                'method' => 'Redención Pack',
                'concept' => 'Sesión descontada del Pack #' . $package->id,
            ]);

            $successMessage = "Sesión descontada. Le quedan {$package->remaining_sessions} sesiones.";

        } else {
            // Opción B: Pago normal (Efectivo/Tarjeta)
            
            // ¿Está comprando un Pack Nuevo?
            if ($request->purchase_type === 'new_pack') {
                // Creamos el pack en la billetera del cliente
                PatientPackage::create([
                    'patient_id' => $appointment->patient_id,
                    'service_id' => $appointment->service_id,
                    'total_sessions' => $appointment->service->sessions_count,
                    'remaining_sessions' => $appointment->service->sessions_count - 1, // Descontamos la de hoy
                    'price_paid' => $request->amount,
                ]);
                
                $concept = "Compra de Pack ({$appointment->service->sessions_count} sesiones)";
            } else {
                $concept = "Servicio Individual: " . $appointment->service->name;
            }

            // Registrar el dinero real
            Payment::create([
                'appointment_id' => $appointment->id,
                'patient_id' => $appointment->patient_id,
                'amount' => $request->amount,
                'method' => $request->payment_method,
                'concept' => $concept,
            ]);

            $successMessage = 'Pago registrado correctamente.';
        }

        // --- BLOQUE 2: FINALIZACIÓN DE CITA (COMÚN PARA AMBOS) ---
        // Este código ahora se ejecuta SIEMPRE, sea Pack o Efectivo

        // 1. Descontar Inventario (Si aún no se ha hecho)
        if ($appointment->status !== 'completed') {
            // Esto descuenta los insumos (guantes, cremas) asociados al servicio
            $appointment->consumeInventory();
        }

        // 2. Actualizar estado de la cita
        $appointment->update([
            'payment_status' => 'paid', 
            'status' => 'completed'
        ]);

        return redirect()->route('appointments.index')->with('success', $successMessage);
    }
}