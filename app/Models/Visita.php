<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;

    protected $fillable=["usuario","fecha_visita","hora_entrada","hora_salida"];
    protected $dates = ['fecha_visita'];
    protected $hidden = ['created_at', 'updated_at'];
    public $monto,$metodo_pago; // atributos temporales


    /**
     * Prepara una fecha para la serialización del modelo.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('d/m/Y');
    }
}
