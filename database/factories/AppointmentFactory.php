<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        // Fecha aleatoria entre hace 1 mes y el próximo mes
        $startTime = fake()->dateTimeBetween('-1 month', '+1 month');
        
        // Clonamos la fecha para sumarle 60 minutos
        $endTime = (clone $startTime)->modify('+60 minutes');

        return [
            // Si no pasamos paciente/servicio, crea uno nuevo o busca existente
            'patient_id' => Patient::factory(), 
            // Truco: Obtener un servicio real de la BD o crear uno falso si está vacía
            'service_id' => Service::inRandomOrder()->first()->id ?? Service::factory(),
            'user_id' => User::first()->id ?? User::factory(), // Asignar al primer usuario (Admin)
            
            'start_time' => $startTime,
            'end_time' => $endTime,
            
            'status' => fake()->randomElement(['scheduled', 'confirmed', 'completed', 'cancelled']),
            'internal_notes' => fake()->sentence(),
            'payment_status' => fake()->randomElement(['pending', 'paid']),
        ];
    }
}
