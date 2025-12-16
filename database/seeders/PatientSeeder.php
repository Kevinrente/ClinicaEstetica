<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        Patient::create([
            'first_name' => 'Vivi',
            'last_name' => 'Ejemplo',
            'email' => 'vivi@cliente.com',
            'phone' => '0991234567',
            'birth_date' => '1995-05-15',
            'occupation' => 'Abogada',
            
            // Datos Médicos de ejemplo
            'medical_history' => [
                'alergias' => 'Ninguna',
                'marcapasos' => false,
                'embarazo' => false,
                'piel_sensible' => true // Visto en
            ],

            // Datos VIP extraídos de
            'vip_preferences' => [
                'bebida' => 'Café',
                'snack' => 'Chocolates',
                'musica' => 'Pop suave',
                'conversacion' => 'Prefiero relajarme en silencio', // ¡Clave para el servicio!
                'aroma' => 'Lavanda'
            ]
        ]);
    }
}