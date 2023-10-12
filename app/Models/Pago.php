<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $fillable=["fecha_pago","miembro_id"];
    protected $hidden = ['created_at', 'updated_at'];

    public function miembro(){
        return $this->belongsTo(Miembro::class);
    }
}
