<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear Usuario Admin
        User::factory()->create([
            'name' => 'Kevin Admin',
            'email' => 'admin@mimate.com',
            'password' => bcrypt('password'), // Contraseña fácil para desarrollo
        ]);

        // 2. Cargar el Catálogo de Servicios Real (Usando el Seeder que hicimos antes)
        $this->call(ServiceSeeder::class);

        // 3. Crear 50 Pacientes Falsos
        // Y para cada paciente, agendarle citas
        Patient::factory(50)->create()->each(function ($patient) {
            
            // Elegimos un servicio al azar para la cita
            $randomService = Service::inRandomOrder()->first();

            Appointment::factory(rand(1, 3))->create([
                'patient_id' => $patient->id,
                'service_id' => $randomService->id,
                'user_id' => 1, // Asignar al admin
            ]);
        });
    }
}