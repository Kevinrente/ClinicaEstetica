<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            
            // Datos Personales Básicos
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable(); // Para WhatsApp
            $table->date('birth_date')->nullable();
            $table->string('occupation')->nullable(); // Visto en ficha
            
            // Contacto de Emergencia
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();

            // 🧠 EL CEREBRO DEL SISTEMA: CAMPOS JSON
            
            // 1. Antecedentes Médicos (Anamnesis)
            // Aquí guardaremos: { "diabetes": true, "marcapasos": false, "alergias": "Penicilina" }
            // Basado en
            $table->jsonb('medical_history')->nullable();

            // 2. Experiencia VIP (CRM)
            // Aquí guardaremos: { "bebida": "Café", "musica": "Jazz", "conversacion": "Silencio" }
            // Basado en
            $table->jsonb('vip_preferences')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};