<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->nullable()->constrained(); // Puede ser pago de una cita
            $table->foreignId('patient_id')->constrained(); // O un abono general
            
            $table->decimal('amount', 10, 2); // Cuánto pagó hoy
            $table->string('method'); // 'Efectivo', 'Tarjeta', 'Transferencia', 'Uso Pack'
            
            // Detalle de lo que está pagando
            $table->string('concept'); // Ej: "Pack Axilas 8 sesiones" o "Limpieza Facial"
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
