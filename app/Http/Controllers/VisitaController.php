<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use Illuminate\Http\Request;

class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return Visita::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
         //TODO adaptar la tabla de visitas, falta agregar el campo de la hora de salida de la visita
        $validated = $request->validate([
            'usuario' => 'required|string|max:100',
            'visited_at' => 'required|date',
            'metodo_pago' => 'required|string|max:100|in:Efectivo,Tarjeta,Transferencia',
            'monto'        => 'required|numeric|min:0',
        ]);

        $visita = new Visita([
            'usuario' => $validated['usuario'],
            'visited_at' => $validated['visited_at'],
        ]);

        $visita->monto = $validated['monto']; // atributo temporal
        $visita->metodo_pago = $validated['metodo_pago']; // atributo temporal
        $visita->save();

        return response()->json([
            'message' => 'Visita registrada correctamente',
            'data' => $visita
        ], 201);
        //return response()->json($visita->load('pago'), 201);//*regresa los datos con la relacion ('pago')



        /*$visita = Visita::create([
            'usuario' => $validated['usuario'],
            'visited_at' => $validated['visited_at'],
        ]);

        return response()->json([
            'message' => 'Visita registrada correctamente',
            'data' => $visita
        ], 201);*/

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function show(Visita $visita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visita $visita)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visita $visita)
    {
        //
    }
}
