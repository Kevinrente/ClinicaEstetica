<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            
            // Datos Básicos
            $table->string('name'); // Ej: "Hidrolipoclasia"
            $table->string('category')->nullable(); // Ej: "Corporal", "Facial", "Lashes"
            $table->text('description')->nullable(); 
            
            // Lógica de Precios Compleja (Detectada en tus imágenes)
            // price_type: 'FIXED' ($25), 'RANGE' ($20-$30), 'FROM' (Desde $20)
            $table->string('price_type')->default('FIXED'); 
            $table->decimal('price', 10, 2)->default(0); // Precio base o mínimo
            $table->decimal('max_price', 10, 2)->nullable(); // Solo si es rango (Ej: Verrugas hasta $30)
            
            // Gestión de Packs y Combos
            $table->integer('sessions_count')->default(1); // Ej: 8 para Depilación, 1 para Limpieza
            
            // JSONB de Postgres: La magia para tus servicios compuestos
            // Aquí guardamos si incluye "3 masajes" sin crear otra tabla intermedia compleja
            $table->jsonb('includes_services')->nullable(); 
            
            // Protocolos y Seguridad
            // Checklist paso a paso (Asepsia, Exfoliación, etc.)
            $table->jsonb('protocol_steps')->nullable(); 
            
            // Contraindicaciones automáticas (Ej: ["embarazo", "marcapasos"])
            // Esto servirá para la validación con IA o lógica simple
            $table->jsonb('contraindications')->nullable();
            
            $table->boolean('requires_consent')->default(false); // Para PRP, Láser, Inyectables
            $table->boolean('active')->default(true); // Para ocultar servicios viejos sin borrarlos

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};