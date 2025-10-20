<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('horarios', function (Blueprint $table) {
      $table->id();
      $table->unsignedTinyInteger('dia_semana'); // 1=Lun...7=Dom
      $table->time('abre');
      $table->time('cierra');
      $table->unsignedSmallInteger('duracion_min')->default(30);
      $table->timestamps();
    });

    Schema::create('bloqueos', function (Blueprint $table) {
      $table->id();
      $table->date('fecha');
      $table->time('hora_inicio');
      $table->time('hora_fin');
      $table->string('motivo')->nullable();
      $table->timestamps();
    });
  }
  public function down(): void {
    Schema::dropIfExists('bloqueos');
    Schema::dropIfExists('horarios');
  }
};