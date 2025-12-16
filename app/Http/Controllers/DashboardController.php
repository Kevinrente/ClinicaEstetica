<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1. Métricas Financieras
        $incomeToday = Payment::whereDate('created_at', $today)->sum('amount');

        // 2. Contadores de Citas
        $appointmentsToday = Appointment::whereDate('start_time', $today)->get();
        $appointmentsCount = $appointmentsToday->count();
        $pendingCount = $appointmentsToday->where('status', 'scheduled')->count();
        $completedCount = $appointmentsToday->where('status', 'completed')->count();

        // 3. Cumpleañeros (Lógica 100% PHP/Carbon compatible con Postgres)
        $upcomingBirthdays = $this->getUpcomingBirthdays();

        // 4. Próximas Citas
        $nextAppointments = Appointment::with(['patient', 'service'])
                            ->where('start_time', '>', now())
                            ->where('status', 'scheduled')
                            ->orderBy('start_time')
                            ->take(5)
                            ->get();

        return view('dashboard', compact(
            'incomeToday', 
            'appointmentsCount', 
            'pendingCount', 
            'completedCount',
            'upcomingBirthdays', 
            'nextAppointments'
        ));
    }

    /**
     * Obtiene los pacientes que cumplen años en los próximos 7 días,
     * utilizando métodos de colección y Carbon (100% compatible con Postgres).
     */
    private function getUpcomingBirthdays()
{
    $today = now();
    $nextWeek = now()->addDays(7);

    // Seleccionamos los pacientes filtrando por Mes y Día por separado
    // Esto es compatible con PostgreSQL y más legible.
    $patients = Patient::whereNotNull('birth_date')
        ->where(function ($query) use ($today, $nextWeek) {
            
            // Caso 1: El cumpleaños es en el mismo mes
            if ($today->month == $nextWeek->month) {
                $query->whereRaw('EXTRACT(MONTH FROM birth_date) = ?', [$today->month])
                      ->whereRaw('EXTRACT(DAY FROM birth_date) BETWEEN ? AND ?', [$today->day, $nextWeek->day]);
            } 
            // Caso 2: El cumpleaños cruza a otro mes (o a otro año)
            else {
                $query->where(function($q) use ($today) {
                    // Días restantes del mes actual
                    $q->whereRaw('EXTRACT(MONTH FROM birth_date) = ?', [$today->month])
                      ->whereRaw('EXTRACT(DAY FROM birth_date) >= ?', [$today->day]);
                })->orWhere(function($q) use ($nextWeek) {
                    // Días del mes siguiente
                    $q->whereRaw('EXTRACT(MONTH FROM birth_date) = ?', [$nextWeek->month])
                      ->whereRaw('EXTRACT(DAY FROM birth_date) <= ?', [$nextWeek->day]);
                });
            }
        })
        ->get();

    // Ordenar y filtrar resultados finales en PHP para precisión absoluta
    return $patients->filter(function($patient) use ($today, $nextWeek) {
        $bdate = $patient->birth_date->copy()->year($today->year);
        
        // Ajustar si el cumpleaños cae el próximo año (caso fin de diciembre)
        if ($bdate->isBefore($today->startOfDay())) {
            $bdate->addYear();
        }
        
        return $bdate->between($today->startOfDay(), $nextWeek->endOfDay());
    })->sortBy(function($patient) use ($today) {
        $bdate = $patient->birth_date->copy()->year($today->year);
        if ($bdate->isBefore($today->startOfDay())) $bdate->addYear();
        return $bdate->timestamp;
    });
}
}