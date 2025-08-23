<?php

namespace App\Services;
use App\Models\Visita;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class VisitaService{
    /**
     * Cierra una visita si cumple con las condiciones.
     *
     * @param int $visitaId
     * @return Visita
     * @throws ValidationException
     */
   // public function cerrarVisita(int $visitaId): Visita{
    public function cerrarVisita(Visita $visita): array{
        if ($visita->hora_salida) {
            return [
                'status' => false,
                'message' => 'La visita ya fue cerrada previamente',
                'data' => $visita
            ];
        }

        $visita->hora_salida = Carbon::now()->format('H:i:s');
        $visita->save();

        return [
            'status' => true,
            'message' => 'Visita cerrada correctamente',
            'data' => $visita
        ];
    



        /*return DB::transaction(function () use ($visitaId) {
            $visita = Visita::findOrFail($visitaId);

            if ($visita->estado !== 'abierta') {
                throw ValidationException::withMessages([
                    'estado' => 'La visita ya está cerrada o en estado inválido.'
                ]);
            }

            $visita->estado = 'cerrada';
            $visita->cerrada_en = now();
            $visita->save();

            return $visita;
        });*/
    }

}