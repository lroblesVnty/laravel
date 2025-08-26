<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return Asistencia::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //TODO FALTA AGREGAR LA FECHA
        $validated = $request->validate([
            'fecha' => 'required|date_format:d-m-Y',
            'miembro_id' => 'required|exists:miembros,id',
            'hora_entrada' => 'required|date_format:H:i:s',
            'hora_salida' => 'required|date_format:H:i:s|after:hora_entrada',
            'notas' => 'nullable|string|max:255',
        ],[
            'hora_entrada.date_format' => 'El formato de la hora de entrada debe ser HH:MM:SS.',
            'hora_salida.date_format' => 'El formato de la hora de salida debe ser HH:MM:SS.',
            'hora_salida.after' => 'La hora de salida debe ser después de la hora de entrada.',
        ]);

        $asistencia = Asistencia::create($validated);

        return response()->json([
            'message' => 'Asistencia registrada correctamente',
            'data' => $asistencia
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function show(Asistencia $asistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asistencia $asistencia)
    {
        //
    }
}
