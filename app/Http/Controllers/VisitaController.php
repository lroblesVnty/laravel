<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


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
        $validated = $request->validate([
            'usuario' => 'required|string|max:100',
            'fecha_visita' => 'required|date',
            'hora_entrada' => 'required|date_format:H:i:s',
            'hora_salida' => 'required|date_format:H:i:s|after:hora_entrada',
            'metodo_pago' => 'required|string|max:100|in:Efectivo,Tarjeta,Transferencia',
            'monto'        => 'required|numeric|min:0',
        ]);

        $visita = new Visita([
            'usuario' => $validated['usuario'],
            'fecha_visita' => $validated['fecha_visita'],
            'hora_entrada' => $validated['hora_entrada'],
            'hora_salida' => $validated['hora_salida'],
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

    public function getVisitasByDate(Request $request){
        //Log::info('Entrando al método getVisitasByDate');
        $request->validate([
            'fecha' => 'nullable|date_format:d-m-Y',
        ]);
        $input = $request->input('fecha');

        $fecha = $input
            ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d')
            : Carbon::today()->format('Y-m-d');
        $visitas = Visita::whereDate('fecha_visita', $fecha)->get();

        if ($visitas->isEmpty()) {
            return response()->json(['message' => 'No hay visitas para esa fecha'], 404);
        }

        return response()->json($visitas, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function show(Visita $visita){
        //Log::info('Entrando al método show'.$visita);
        return Visita::findOrFail($visita->id);
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
