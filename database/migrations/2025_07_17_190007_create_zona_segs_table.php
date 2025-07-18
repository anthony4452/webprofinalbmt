<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zona_segs', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo_seguridad');
            $table->float('radio');
            $table->double('latitud');
            $table->double('longitud');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zonasegs');
    }
};
