<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index(){
        /*$planes=Plan::all();
        return $planes;*/
        $planes=Plan::with('miembro:id,nombre')->get();
        //$planes=Plan::with('miembro:id,nombre')->get(['id','status','membresia_id','miembro_id']);
       // $ventas=Venta::with('productos','user')->get(['id','created_at AS fecha_venta','total','user_id']);
       
        return $planes;
    }

    public function store(Request $request){
        $request->validate([
            'miembro_id'=>'required|integer|exists:miembros,id|unique:plans,miembro_id',
            'membresia_id'=>'required|integer|exists:membresias,id',
            'status'=>'required|string|in:inactivo,activo',
        ]);
        $plan=Plan::create($request->all());
        return $plan;
    }    
}
