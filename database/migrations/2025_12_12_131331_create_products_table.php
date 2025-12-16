<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ej: Ampolla Alcachofa
            $table->string('sku')->nullable(); // Código de barras opcional
            $table->integer('stock')->default(0); 
            $table->integer('min_stock')->default(5); // Alerta si baja de esto
            $table->string('unit'); // ml, unidad, gramo
            $table->decimal('cost', 10, 2)->nullable(); // Costo de compra (para reportes de ganancia real)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
