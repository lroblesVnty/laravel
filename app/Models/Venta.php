<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at','pivot'];
    protected $fillable=["user_id","total"];
    public function productos(){
        return $this->belongsToMany(Producto::class,'producto_venta')->withTimestamps();
    }
}
