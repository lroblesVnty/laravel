<?php

namespace App\Observers;

use App\Models\Pago;
use App\Models\Visita;

class VisitaObserver{
     //**se tiene que registrar en el archivo EventServiceProvider.php */
    /**
     * Handle the Visita "created" event.
     *
     * @param  \App\Models\Visita  $visita
     * @return void
     */
    public function created(Visita $visita){
        Pago::create([
            'miembro_id' => 10,
            'plan_id' => 10,
            'metodo_pago' => $visita->metodo_pago,
            'monto' => $visita->monto,
            // no se necesita agregar fecha_pago ni expira_en aquí
        ]);

    }

    /**
     * Handle the Visita "updated" event.
     *
     * @param  \App\Models\Visita  $visita
     * @return void
     */
    public function updated(Visita $visita)
    {
        //
    }

    /**
     * Handle the Visita "deleted" event.
     *
     * @param  \App\Models\Visita  $visita
     * @return void
     */
    public function deleted(Visita $visita)
    {
        //
    }

    /**
     * Handle the Visita "restored" event.
     *
     * @param  \App\Models\Visita  $visita
     * @return void
     */
    public function restored(Visita $visita)
    {
        //
    }

    /**
     * Handle the Visita "force deleted" event.
     *
     * @param  \App\Models\Visita  $visita
     * @return void
     */
    public function forceDeleted(Visita $visita)
    {
        //
    }
}
