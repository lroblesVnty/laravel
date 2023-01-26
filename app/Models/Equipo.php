<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;
    protected $hidden = ['updated_at'];
    protected $fillable=["nserie","tipo","marca","modelo","fechaCompra","costo","procesador","ram","hdd","software","user_id","proveedor_id"];

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
