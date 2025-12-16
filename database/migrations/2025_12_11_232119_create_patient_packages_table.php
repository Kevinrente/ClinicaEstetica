<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('service_id')->constrained(); // Qué servicio compró (Ej. Depilación Axilas)
            
            $table->integer('total_sessions'); // 8
            $table->integer('remaining_sessions'); // Va bajando: 7, 6, 5...
            
            $table->decimal('price_paid', 10, 2); // Cuánto pagó por el pack ($140)
            $table->date('expires_at')->nullable(); // Validez del pack
            
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_packages');
    }
};
