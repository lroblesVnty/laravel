<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miembro extends Model
{
    use HasFactory;
    protected $fillable=["nombre","tel","edad"];
    protected $hidden = ['created_at', 'updated_at'];

    public function plan(){
        return $this->hasOne(Plan::class);
    }

    public function pagos(){
        return $this->hasMany(Pago::class);
    }
}
