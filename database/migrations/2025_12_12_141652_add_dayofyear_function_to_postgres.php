<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Solo ejecutamos esto si estamos en Postgres (pgsql)
        if (config('database.default') === 'pgsql') {
            // Creamos la función dayofyear que Postgres no tiene por defecto
            DB::unprepared('
                CREATE OR REPLACE FUNCTION dayofyear(date) RETURNS integer AS $$
                SELECT extract(doy from $1)::integer;
                $$ LANGUAGE sql IMMUTABLE STRICT;
            ');
        }
    }

    public function down(): void
    {
        if (config('database.default') === 'pgsql') {
            DB::unprepared('DROP FUNCTION IF EXISTS dayofyear(date);');
        }
    }
};
