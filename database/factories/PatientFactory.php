<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    public function definition(): array
    {
        // Generamos preferencias VIP aleatorias
        $vipPrefs = [
            'conversacion' => fake()->randomElement(['Conversar', 'Silencio', 'Depende del día']),
            'bebida' => fake()->randomElement(['Agua', 'Café', 'Té', 'Gaseosa', 'Nada']),
            'musica' => fake()->randomElement(['Pop', 'Jazz', 'Clásica', 'Reggaeton', 'Naturaleza']),
            'snack' => fake()->randomElement(['Chocolate', 'Frutos Secos', 'Galletas']),
        ];

        // Generamos historial médico aleatorio (Simulando lo que vimos en las fichas)
        $medical = [
            'diabetes' => fake()->boolean(10), // 10% de probabilidad
            'hipertension' => fake()->boolean(15),
            'marcapasos' => fake()->boolean(1), // Muy raro
            'alergias' => fake()->boolean(20) ? fake()->word() : 'Ninguna',
            'embarazo' => fake()->boolean(5),
            'piel_sensible' => fake()->boolean(30),
        ];

        return [
            'first_name' => fake()->firstName('female'), // Mayoría mujeres en estética
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'birth_date' => fake()->dateTimeBetween('-50 years', '-18 years'), // Adultos
            'occupation' => fake()->jobTitle(),
            
            'emergency_contact_name' => fake()->name(),
            'emergency_contact_phone' => fake()->phoneNumber(),
            
            // Campos JSON
            'medical_history' => $medical,
            'vip_preferences' => $vipPrefs,
        ];
    }
}
