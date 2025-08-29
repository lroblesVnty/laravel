<?php

namespace App\Services;

use App\Models\Asistencia;
use Carbon\Carbon;

class AsistenciaService
{
     public function cerrarAsistencia(Asistencia $asistencia): array{
        if ($asistencia->hora_salida) {
            return [
                'status' => false,
                'message' => 'La asistencia ya fue cerrada previamente',
                'data' => $asistencia
            ];
        }

        $asistencia->hora_salida = Carbon::now()->format('H:i:s');
        $asistencia->save();

        return [
            'status' => true,
            'message' => 'Asistencia cerrada correctamente',
            'data' => $asistencia
        ];
    }
}