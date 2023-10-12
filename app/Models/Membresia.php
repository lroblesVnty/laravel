<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    use HasFactory;
    protected $fillable=["nombre","costo"];
    protected $hidden = ['created_at', 'updated_at'];
}
