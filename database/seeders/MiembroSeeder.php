<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MiembroSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('miembros')->insert([
            [
                'nombre' => 'Usuario',
                'apellido' => 'Visita',
                'tel' => '1234567895',
                'edad' => 15,
                'plan_id' => 1,
            ],
            // Agrega más miembros según sea necesario
        ]);
    }
}
