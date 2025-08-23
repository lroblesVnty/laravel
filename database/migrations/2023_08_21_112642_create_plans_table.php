<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_plan')->nullable(false)->unique();
            $table->string('descripcion')->nullable(false);
            $table->enum('frecuencia_pago', ['semanal', 'mensual', 'anual','visita']);
            $table->double('costo',8,2)->nullable(false);
            $table->integer('duracion_dias')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
