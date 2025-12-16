<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained();
            // Opcional: Si tienes varios doctores/esteticistas
            $table->foreignId('user_id')->nullable()->constrained(); 
            
            // Tiempo
            $table->dateTime('start_time');
            $table->dateTime('end_time'); // Se calculará automático según duración del servicio
            
            // Estados del Flujo de Trabajo
            // 'scheduled' (Agendada), 'confirmed' (Confirmada), 'in_progress' (En cabina), 
            // 'completed' (Finalizada), 'cancelled' (Cancelada), 'no_show' (No asistió)
            $table->string('status')->default('scheduled');
            
            // Notas de recepción (Ej: "Viene atrasada 5 min")
            $table->text('internal_notes')->nullable();
            
            // Control Financiero Básico (Preparando para facturación)
            $table->string('payment_status')->default('pending'); // pending, partial, paid
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};