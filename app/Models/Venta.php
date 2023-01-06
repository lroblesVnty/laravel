<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $hidden = ['updated_at'];
    protected $fillable=["user_id","total"];
    
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y H:i:s');
    }
    public function productos(){
       // return $this->belongsToMany(Producto::class,'producto_venta')->withTimestamps()->withPivot('producto_cantidad');
        return $this->belongsToMany(Producto::class,'producto_venta')->using(ProductoVenta::class)->as('detalle')->withTimestamps()->withPivot('producto_cantidad');//using= modelo personalizado con la tabla pivot para exlcluir los timestamps
    }
}
