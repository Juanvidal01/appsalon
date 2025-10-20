<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            // Si la columna no existe aún, se agrega
            if (!Schema::hasColumn('citas', 'estado')) {
                $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])
                      ->default('pendiente')
                      ->after('total'); // o después de la columna que prefieras
            }
        });
    }

    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
