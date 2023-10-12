<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index(){
        /*$planes=Plan::all();
        return $planes;*/
        $pagos=Pago::with('miembro:id,nombre')->get();
        //$planes=Plan::with('miembro:id,nombre')->get(['id','status','membresia_id','miembro_id']);
       // $ventas=Venta::with('productos','user')->get(['id','created_at AS fecha_venta','total','user_id']);
       
        return $pagos;
    }

    public function store(Request $request){
        $request->validate([
            'fecha_pago'=>'required|date_format:Y-m-d H:i:s',
            'miembro_id'=>'required|integer|exists:miembros,id'
        ]);
        $pago=Pago::create($request->all());
        return $pago;
    }    
}
