<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model{
    use HasFactory;
    protected $table='asistencia';
    protected $fillable=["miembro_id","hora_entrada","hora_salida","notas"];
    protected $dates = ['hora_entrada', 'hora_salida'];
    protected $hidden = ['created_at', 'updated_at'];
}
