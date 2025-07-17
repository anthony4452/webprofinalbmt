<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zonas_seguras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->float('radio'); // en metros
            $table->double('latitud');
            $table->double('longitud');
            $table->string('tipo_seguridad');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zonas_seguras');
    }
};
