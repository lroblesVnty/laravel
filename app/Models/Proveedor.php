<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $fillable=["nombre"];
    protected $hidden = ['created_at', 'updated_at'];

    public function equipos(){
        return $this->hasMany(Equipo::class);
    }
}
