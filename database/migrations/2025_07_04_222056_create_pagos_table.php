<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha_pago');
            $table->timestamp('expira_en')->nullable();
            $table->foreignId('miembro_id')->constrained('miembros');
            $table->foreignId('plan_id')->constrained('plans');
            $table->double('monto',8,2)->nullable(false);
            $table->string('metodo_pago')->nullable(false);
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
        Schema::dropIfExists('pagos');
    }
}
