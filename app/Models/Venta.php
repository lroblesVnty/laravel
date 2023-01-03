<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable=["user_id","total"];
    public function productos(){
       // return $this->belongsToMany(Producto::class,'producto_venta')->withTimestamps()->withPivot('producto_cantidad');
        return $this->belongsToMany(Producto::class,'producto_venta')->using(ProductoVenta::class)->as('detalle')->withTimestamps()->withPivot('producto_cantidad');//using= modelo personalizado con la tabla pivot para exlcluir los timestamps
    }
}
