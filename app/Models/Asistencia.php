<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model{
    use HasFactory;
    protected $table='asistencia';
    protected $fillable=["miembro_id","hora_entrada","hora_salida","notas","fecha"];
    protected $dates = ['fecha'];
    protected $hidden = ['created_at', 'updated_at'];
    //protected $hidden = ['miembro_id'];//? Ocultar miembro_id en las respuestas JSON


    public function miembro(){
        return $this->belongsTo(Miembro::class);
    }

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
