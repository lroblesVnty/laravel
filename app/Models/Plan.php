<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable=["miembro_id","membresia_id","status"];
    protected $hidden = ['created_at', 'updated_at'];

    public function miembro(){
        return $this->belongsTo(Miembro::class);
    }

    public function membresia(){
        return $this->belongsTo(Membresia::class);
    }


}
