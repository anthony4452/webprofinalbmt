<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('zona_riesgos', function (Blueprint $table) {
            $table->boolean('activo')->default(true)->after('coordenadas');
        });
    }

    public function down()
    {
        Schema::table('zona_riesgos', function (Blueprint $table) {
            $table->dropColumn('activo');
        });
    }

};
