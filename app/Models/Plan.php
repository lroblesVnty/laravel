<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable=["nombre_plan","descripcion","fecuencia_pago","costo","duracion_dias"];
    protected $hidden = ['created_at', 'updated_at'];

    public function miembros(){
        return $this->hasMany(Miembro::class);
    }

     // Si un plan tiene muchos pagos (relación inversa)
    public function pagos(){
        return $this->hasMany(Pago::class);
    }


}
