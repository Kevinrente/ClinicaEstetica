<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinical_sheets', function (Blueprint $table) {
            $table->id();
            
            // Relaciones Clave
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade')->unique(); // Una ficha por cita
            $table->foreignId('patient_id')->constrained(); // Duplicamos para consultas rápidas

            // Tipo de Ficha (Para saber qué formulario mostrar)
            // Valores posibles: 'facial', 'corporal', 'lashes', 'other_invasive'
            $table->string('sheet_type'); 
            
            // 🧠 Contenido Dinámico de la Ficha (JSONB)
            // Aquí se guarda todo: diagnóstico facial, medidas corporales, productos usados, etc.
            $table->jsonb('sheet_data'); 
            
            // Seguimiento
            $table->text('final_notes')->nullable();
            
            // Check: ¿Se firmó el consentimiento informado?
            $table->boolean('consent_signed')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinical_sheets');
    }
};