<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\ClinicalSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Importante para la transacción

class ClinicalSheetController extends Controller
{
    public function store(Request $request, Appointment $appointment)
    {
        // 1. Validamos todos los datos de entrada
        $request->validate([
            'sheet_data' => 'required|array',
            'sheet_type' => 'required|string',
            'final_notes' => 'nullable|string', // Añadido por seguridad
        ]);

        try {
            // 2. Iniciamos una transacción de Base de Datos
            DB::transaction(function () use ($request, $appointment) {
                
                // A. Guardamos o actualizamos la ficha clínica
                ClinicalSheet::updateOrCreate(
                    ['appointment_id' => $appointment->id],
                    [
                        'patient_id' => $appointment->patient_id,
                        'sheet_type' => $request->sheet_type,
                        'sheet_data' => $request->sheet_data,
                        'final_notes' => $request->final_notes,
                        // No forzamos consent_signed aquí, eso va en el otro controlador
                    ]
                );

                // B. Lógica de Inventario (Solo si la cita NO estaba cerrada antes)
                // Esto evita que si editan la ficha, se descuente el inventario 2 veces.
                if ($appointment->status !== 'completed') {
                    $appointment->consumeInventory();
                }
                
                // C. Finalizar la sesión
                $appointment->update(['status' => 'completed']);
            });

            return redirect()->route('appointments.index')
                ->with('success', 'Ficha clínica guardada, inventario actualizado y sesión finalizada.');

        } catch (\Exception $e) {
            // Si algo falla, volvemos atrás con el error
            return back()->with('error', 'Error al guardar la ficha: ' . $e->getMessage());
        }
    }
}