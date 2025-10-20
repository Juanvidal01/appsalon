<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellido')->nullable()->after('name');
            $table->string('telefono')->nullable()->after('email');
            $table->boolean('admin')->default(false)->after('telefono');
            $table->boolean('confirmado')->default(false)->after('admin');
            $table->string('token')->nullable()->index()->after('confirmado');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['apellido', 'telefono', 'admin', 'confirmado', 'token']);
        });
    }
};