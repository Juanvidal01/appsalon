<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('citas', function (Blueprint $table) {
      $table->id();
      $table->date('fecha');
      $table->time('hora');      // inicio
      $table->time('hora_fin');  // fin (bloque)
      $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
      $table->enum('estado',['pendiente','confirmada','cancelada'])->default('pendiente');
      $table->timestamps();
      $table->unique(['fecha','hora','hora_fin'], 'citas_unicas_por_bloque'); // evitar solapes básicos
    });
  }
  public function down(): void { Schema::dropIfExists('citas'); }
};