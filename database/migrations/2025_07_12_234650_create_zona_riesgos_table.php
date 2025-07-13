<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('zona_riesgos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->enum('nivel_riesgo', ['bajo', 'medio', 'alto']);
            $table->longText('coordenadas'); // aquí puedes guardar las coordenadas como JSON o texto plano
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zona_riesgos');
    }
};
