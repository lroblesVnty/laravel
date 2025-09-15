<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('users')->insert([
            [
                'name' => 'Thiago Silva',
                'email' => 'thiago.silva@example.com',
                'password' => Hash::make('Th1ag0$ilva!'), // Encriptar la contraseña
            ],
            // Agrega más miembros según sea necesario
        ]);
    }
}
