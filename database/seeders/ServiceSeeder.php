<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // --- LIMPIEZAS FACIALES ---
            [
                'name' => 'Limpieza Facial Teenager',
                'description' => 'Especial para adolescentes que inician con su rutina de skincare. Limpieza suave y educativa.',
                'price' => 20.00,
                'duration' => 45,
                'sessions_count' => 1,
            ],
            [
                'name' => 'Limpieza Facial Básica',
                'description' => 'Incluye limpieza profunda, vapor ozono y aparatología básica para mantener la piel sana.',
                'price' => 25.00,
                'duration' => 60,
                'sessions_count' => 1,
            ],
            [
                'name' => 'Limpieza Facial Profunda',
                'description' => 'Protocolo completo: Asepsia, Tonificación, Exfoliación, Microdermoabrasión, Extracción de puntos negros, Alta Frecuencia, Mascarilla Hidratante, Fototerapia y Pantalla Solar.',
                'price' => 25.00,
                'duration' => 90,
                'sessions_count' => 1,
            ],
            [
                'name' => 'Limpieza Facial Estándar (Acné)',
                'description' => 'Tratamiento especializado con aparatología, ácidos despigmentantes y punta de diamante. Ideal para pieles con acné.',
                'price' => 30.00,
                'duration' => 90,
                'sessions_count' => 1,
            ],
            [
                'name' => 'Limpieza Facial Premium (Antiage)',
                'description' => 'Facial anti-edad. Incluye hidratación profunda para bolsas y ojeras con galvánica, drenaje facial y ultrasonido.',
                'price' => 35.00,
                'duration' => 90,
                'sessions_count' => 1,
            ],
            [
                'name' => 'Tratamiento Pieles con Acné Severo',
                'description' => 'Limpieza profunda y tratamiento intensivo para brotes activos y control de grasa.',
                'price' => 35.00,
                'duration' => 90,
                'sessions_count' => 1,
            ],

            // --- REJUVENECIMIENTO Y PIEL ---
            [
                'name' => 'Dermaplaning',
                'description' => 'Elimina células muertas y vello facial (pelusa). Favorece la absorción de productos y atenúa líneas finas. ¡Incluye Limpieza Facial!',
                'price' => 30.00,
                'duration' => 60,
                'sessions_count' => 1,
            ],
            [
                'name' => 'Mesoterapia Facial',
                'description' => 'Hidratación profunda. Estimula colágeno y elastina. Reduce arrugas, líneas finas y mejora la textura y tono de la piel.',
                'price' => 45.00,
                'duration' => 60,
                'sessions_count' => 1,
                'requires_consent' => true,
            ],
            [
                'name' => 'Radiofrecuencia Facial',
                'description' => 'Rejuvenece la piel, contrae colágeno, reduce grasa y previene acné. ¡Incluye Limpieza Facial!',
                'price' => 25.00,
                'duration' => 60,
                'sessions_count' => 1,
            ],
            [
                'name' => 'Microneedling Dermapen',
                'description' => 'Estimula producción de colágeno. Reduce arrugas, manchas y cicatrices de acné. Deja la piel suave y uniforme.',
                'price' => 40.00,
                'duration' => 60,
                'sessions_count' => 1,
                'requires_consent' => true,
            ],
            [
                'name' => 'Hollywood Peel',
                'description' => 'Piel de porcelana con láser carbón. Reduce poros, pigmentación y líneas finas. Efecto glow inmediato.',
                'price' => 40.00,
                'duration' => 60,
                'sessions_count' => 1,
                'requires_consent' => true,
            ],
            [
                'name' => 'Despigmentación Facial/Corporal',
                'description' => 'Tratamiento específico para reducir manchas y unificar el tono de la piel.',
                'price' => 40.00,
                'duration' => 60,
                'sessions_count' => 1,
            ],

            // --- PLASMA RICO EN PLAQUETAS ---
            [
                'name' => 'Plasma Rico en Plaquetas (Rostro)',
                'description' => 'Brinda poderosa reparación cutánea, desaparece marcas de acné y genera hidratación profunda.',
                'price' => 35.00,
                'duration' => 60,
                'sessions_count' => 1,
                'requires_consent' => true,
            ],
            [
                'name' => 'Plasma Rico en Plaquetas (Cabello)',
                'description' => 'Estimula el crecimiento capilar y mejora la salud del cabello de manera no invasiva.',
                'price' => 35.00,
                'duration' => 60,
                'sessions_count' => 1,
                'requires_consent' => true,
            ],

            // --- CORPORALES Y REDUCTORES ---
            [
                'name' => 'Masajes Relajantes',
                'description' => 'Terapia manual para reducir estrés y tensión muscular.',
                'price' => 20.00,
                'duration' => 60,
                'sessions_count' => 1,
            ],
            [
                'name' => 'Masajes Relajantes Plus',
                'description' => 'Incluye piedras calientes, masajeador o ventosas para una relajación profunda.',
                'price' => 25.00,
                'duration' => 70,
                'sessions_count' => 1,
            ],
            [
                'name' => 'Masajes Reductores',
                'description' => 'Masaje vigoroso para moldear y reducir medidas. Valor por sesión.',
                'price' => 15.00,
                'duration' => 45,
                'sessions_count' => 1,
            ],
            [
                'name' => 'Mesoterapia Corporal (Reductor)',
                'description' => 'Inyecciones quema-grasa localizadas. Incluye 1 masaje.',
                'price' => 50.00,
                'duration' => 60,
                'sessions_count' => 1,
                'requires_consent' => true,
            ],
            [
                'name' => 'Hidrolipoclasia',
                'description' => 'Tratamiento intensivo para reducción de grasa localizada ("Lipo sin cirugía"). Incluye 3 masajes.',
                'price' => 120.00,
                'duration' => 90,
                'sessions_count' => 1,
                'requires_consent' => true,
            ],

            // --- DEPILACIÓN LÁSER ---
            [
                'name' => 'Láser Axilas',
                'description' => 'Depilación definitiva zona axilas.',
                'price' => 20.00,
                'duration' => 20,
                'sessions_count' => 1,
                'requires_consent' => true,
            ],
            [
                'name' => 'Láser Facial Medio',
                'description' => 'Depilación definitiva mitad del rostro.',
                'price' => 15.00,
                'duration' => 20,
                'sessions_count' => 1,
                'requires_consent' => true,
            ],
            [
                'name' => 'Láser Facial Completo',
                'description' => 'Depilación definitiva rostro completo.',
                'price' => 20.00,
                'duration' => 30,
                'sessions_count' => 1,
                'requires_consent' => true,
            ],
            [
                'name' => 'Láser Medio Bikini',
                'description' => 'Depilación definitiva zona bikini medio.',
                'price' => 20.00,
                'duration' => 30,
                'sessions_count' => 1,
                'requires_consent' => true,
            ],
            [
                'name' => 'Láser Medio Brazo',
                'description' => 'Depilación definitiva zona brazos (media).',
                'price' => 25.00,
                'duration' => 30,
                'sessions_count' => 1,
                'requires_consent' => true,
            ],
            [
                'name' => 'Láser Media Pierna',
                'description' => 'Depilación definitiva zona piernas (media).',
                'price' => 35.00,
                'duration' => 40,
                'sessions_count' => 1,
                'requires_consent' => true,
            ],

            // --- OTROS SERVICIOS ---
            [
                'name' => 'Eliminación Cejas Tatuadas',
                'description' => 'Remoción de pigmento en cejas. Valor por sesión.',
                'price' => 20.00,
                'duration' => 45,
                'sessions_count' => 1,
            ],
            [
                'name' => 'Eliminación Tatuajes (Corporal)',
                'description' => 'Valor base por sesión. El precio final depende del tamaño del tatuaje.',
                'price' => 20.00,
                'duration' => 45,
                'sessions_count' => 1,
            ],
            [
                'name' => 'Cauterización Verrugas/Lunares',
                'description' => 'Eliminación segura de imperfecciones. Valor entre $20 y $30 según cantidad.',
                'price' => 25.00, 
                'duration' => 30,
                'sessions_count' => 1,
            ],
        ];

        // 1. Crear o Actualizar los Servicios básicos
        foreach ($services as $service) {
            Service::updateOrCreate(
                ['name' => $service['name']], 
                $service
            );
        }

        // 2. ACTUALIZACIÓN DE TEXTOS LEGALES (Consentimientos)
        
        // Texto Básico (Faciales normales)
        $textoBasico = "Declaro haber sido informada sobre el procedimiento, sus beneficios y posibles efectos secundarios leves como enrojecimiento temporal. Autorizo la realización del tratamiento.";

        // Texto Láser (Riesgo de quemadura/manchas)
        $textoLaser = "Entiendo que la Depilación Láser utiliza energía térmica. Se me ha informado que no debo haber tomado sol 72 horas antes. Riesgos posibles: Hipopigmentación temporal, enrojecimiento o leve irritación. Me comprometo a usar protector solar post-sesión.";

        // Texto Invasivo (Mesoterapia, Hidrolipoclasia - Hematomas/Infección)
        $textoInvasivo = "Autorizo la aplicación de microinyecciones o infiltraciones. Entiendo que pueden surgir hematomas (moretones), leve inflamación o sensibilidad en la zona. He informado verazmente sobre alergias a medicamentos o embarazo.";

        // Asignación de Textos Legales
        $updates = [
            // Faciales Básicos
            ['Limpieza Facial Profunda', $textoBasico],
            ['Hollywood Peel', $textoLaser],
            ['Microneedling Dermapen', $textoBasico],
            
            // Invasivos / Inyecciones
            ['Mesoterapia Facial', $textoInvasivo],
            ['Plasma Rico en Plaquetas (Rostro)', $textoInvasivo],
            ['Mesoterapia Corporal (Reductor)', $textoInvasivo],
            ['Hidrolipoclasia', $textoInvasivo],
            
            // Láser
            ['Láser Axilas', $textoLaser],
            ['Láser Facial Completo', $textoLaser],
            ['Láser Facial Medio', $textoLaser],
            ['Láser Media Pierna', $textoLaser],
            ['Láser Medio Bikini', $textoLaser],
            ['Láser Medio Brazo', $textoLaser],
            
            // Otros
            ['Eliminación Tatuajes (Corporal)', "Entiendo que la eliminación de tatuajes puede requerir múltiples sesiones y existe riesgo de hipopigmentación o cicatrización leve."],
            ['Cauterización Verrugas/Lunares', "Autorizo la cauterización. Entiendo que se formará una costra que no debo arrancar para evitar cicatrices."],
        ];

        foreach ($updates as $update) {
            Service::where('name', $update[0])->update(['legal_text' => $update[1]]);
        }
    }
}