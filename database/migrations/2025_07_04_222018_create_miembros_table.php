<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiembrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miembros', function (Blueprint $table) {
           $table->id();
            $table->timestamps();
            $table->string('nombre')->nullable(false);
            $table->string('apellido')->nullable(false);
            $table->string('tel')->nullable(false)->unique();;
            $table->tinyInteger('edad')->nullable(false);
            $table->tinyInteger('activo')->default(0); 
            $table->foreignId('plan_id')->constrained('plans')
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
        Schema::dropIfExists('miembros');
    }
}
