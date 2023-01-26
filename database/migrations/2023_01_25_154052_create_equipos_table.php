<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('nserie')->unique();
            $table->string('tipo');
            $table->string('marca');
            $table->string('modelo');
            $table->date('fechaCompra');
            $table->double('costo');
            $table->string('procesador');
            $table->integer('ram')->nullable();
            $table->string('hdd')->nullable();
            $table->string('software');
            $table->timestamps();
            $table->foreignId('proveedor_id')->constrained('proveedors')
            ->onUpdate('cascade')
             // o tambien $table->cascadeOnDelete();
            ->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipos');
    }
}
