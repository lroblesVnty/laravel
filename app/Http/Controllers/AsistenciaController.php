<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Services\AsistenciaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return Asistencia::with('miembro')->get()->makeHidden('miembro_id');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validated = $request->validate([
            'fecha' => 'required|date_format:d-m-Y',
            'miembro_id' => 'required|exists:miembros,id',
            'hora_entrada' => 'required|date_format:H:i:s',
            //'hora_salida' => 'required|date_format:H:i:s|after:hora_entrada',
            'notas' => 'nullable|string|max:255',
        ],[
            'hora_entrada.date_format' => 'El formato de la hora de entrada debe ser HH:MM:SS.',
            //'hora_salida.date_format' => 'El formato de la hora de salida debe ser HH:MM:SS.',
            //'hora_salida.after' => 'La hora de salida debe ser después de la hora de entrada.',
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

    public function getAsistenciaByDate(Request $request){
        //Log::info('Entrando al método getAsistenciaByDate');
        $request->validate([
            'fecha' => 'nullable|date_format:d-m-Y',
        ]);
        $input = $request->input('fecha');

        $fecha = $input
            ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d')
            : Carbon::today()->format('Y-m-d');
        $asistencias = Asistencia::with('miembro')->whereDate('fecha', $fecha)->get()->makeHidden('miembro_id');

        if ($asistencias->isEmpty()) {
            return response()->json(['message' => 'No hay asistencias para esa fecha'], 404);
        }

        return response()->json($asistencias, 200);
    }

    /**
     * cerrar asistencia, registrar hora de salida, usando un servicio
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function closeAsistencia(Asistencia $asistencia, AsistenciaService $asistenciaService){
        $resultado = $asistenciaService->cerrarAsistencia($asistencia);

        return response()->json([
            'message' => $resultado['message'],
            'data' => $resultado['data']
        ], $resultado['status'] ? 200 : 409);
    }

     /**
     * Display the specified resource by miembro.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function asistenciaByMiembroToDay($miembro){
        
         // Obtener la fecha actual
        $hoy = Carbon::today();
        Log::info('fechaHoy '. $hoy);
        // verificar asistencia para el miembro y la fecha de hoy
        $asistencia = Asistencia::where('miembro_id', $miembro)
            ->whereDate('fecha', $hoy)
            ->first();
            //->makeHidden('miembro_id');

        if (!$asistencia) {
            return response()->json(['message' => 'No hay asistencias para este miembro en la fecha actual'], 404);
        }


        return response()->json($asistencia, 200);
    }
}
