<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PlanesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('plans')->insert([
            [
                'nombre_plan' => 'Básico Semanal',
                'descripcion' => 'Acceso limitado a funcionalidades principales',
                'frecuencia_pago' => 'semanal',
                'costo' => 60,
                'duracion_dias' => 7,
            ],
            [
                'nombre_plan' => 'Premium Semanal',
                'descripcion' => 'Acceso completo sin restricciones',
                'frecuencia_pago' => 'semanal',
                'costo' => 499,
                'duracion_dias' => 30,
            ],
            [
                'nombre_plan' => 'Anual Pro',
                'descripcion' => 'Funcionalidades premium con precio preferencial',
                'frecuencia_pago' => 'anual',
                'costo' => 4999,
                'duracion_dias' => 360,
            ],
            [
                'nombre_plan' => 'Semanal Plus',
                'descripcion' => 'Ideal para uso temporal con funciones clave',
                'frecuencia_pago' => 'semanal',
                'costo' => 79,
                'duracion_dias' => 7,
            ],
            [
                'nombre_plan' => 'Empresarial',
                'descripcion' => 'Soporte dedicado y múltiples usuarios',
                'frecuencia_pago' => 'anual',
                'costo' => 9999,
                'duracion_dias' => 360,
            ],
            [
                'nombre_plan' => 'Plan Freelance',
                'descripcion' => 'Pensado para trabajadores independientes',
                'frecuencia_pago' => 'mensual',
                'costo' => 349,
                'duracion_dias' => 30,
            ],
            [
                'nombre_plan' => 'Plan Estudiante',
                'descripcion' => 'Descuento especial para estudiantes',
                'frecuencia_pago' => 'mensual',
                'costo' => 149,
                'duracion_dias' => 30,
            ],
            [
                'nombre_plan' => 'Visita',
                'descripcion' => 'Visita de un Usuario',
                'frecuencia_pago' => null,
                'costo' => 30,
                'duracion_dias' => 1,
            ],
        ]);

    }
}
