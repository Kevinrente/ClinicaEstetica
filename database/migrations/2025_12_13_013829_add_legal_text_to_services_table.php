<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('services', function (Blueprint $table) {
        // Campo de texto largo para el contrato específico
        $table->longText('legal_text')->nullable()->after('requires_consent');
    });
}

public function down(): void
{
    Schema::table('services', function (Blueprint $table) {
        $table->dropColumn('legal_text');
    });
}
};
