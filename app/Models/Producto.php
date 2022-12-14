<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Producto extends Model
{
    use HasFactory;
    protected $fillable=["descripcion","precio","stock"];
    protected $hidden = ['created_at', 'updated_at','pivot'];
    public function ventas(){
        return $this->belongsToMany(Venta::class,'producto_venta');
    }
}
