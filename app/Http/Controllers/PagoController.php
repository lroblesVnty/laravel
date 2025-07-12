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
        $validated = $request->validate([
            'miembro_id' => 'required|exists:miembros,id',
            'plan_id' => 'required|exists:plans,id',
            'metodo_pago' => 'required|string|max:100',
            'monto'        => 'required|numeric|min:0',
            /*'monto'=>['required|numeric|min:0.01',//*funcion para validar que el pago sea mayor al costo del plan
            function ($attribute, $value, $fail) {
                    $plan = Plan::find($this->plan_id);
                    if (!$plan) {
                        $fail('El plan seleccionado no es válido.');
                        return;
                    }
                    if ($value < $plan->costo) { // Asume que el costo del plan está en la columna 'costo' de tu tabla 'planes'
                        $fail("El :attribute debe ser mayor o igual al costo del plan (" . $plan->costo . ").");
                    }
                }
            ,]*/
            
            
            // 'fecha_pago' opcional, se maneja en el modelo
        ]);

        $pago = Pago::create([
            'miembro_id' => $validated['miembro_id'],
            'plan_id' => $validated['plan_id'],
            'metodo_pago' => $validated['metodo_pago'],
            'monto' => $validated['monto'],
            // no se necesita agregar fecha_pago ni expira_en aquí
        ]);

        return response()->json([
            'message' => 'Pago registrado correctamente',
            'data' => $pago
        ], 201);

    }    
}
