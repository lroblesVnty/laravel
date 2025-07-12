<?php

namespace App\Observers;

use App\Models\Pago;
use Illuminate\Validation\ValidationException;


class PagoObserver{

     /**
     * Handle the Pago "creating" event.
     *
     * @param  \App\Models\Pago  $pago
     * @return void
     */
    public function creating(Pago $pago){
        $plan = $pago->plan;

        if ($plan && $pago->monto < $plan->costo) {
            throw ValidationException::withMessages([
                'monto' => 'El monto del pago no puede ser menor al costo del plan.',
            ]);
        }
    }



    /**
     * Handle the Pago "created" event.
     *
     * @param  \App\Models\Pago  $pago
     * @return void
     */
    public function created(Pago $pago){
        // Actualizar el estatus del miembro
        $miembro = $pago->miembro; // Asumiendo una relación belongsTo en el modelo Pago con Miembro

        if ($miembro) {
            if ($pago->monto >= $pago->plan->costo) {
                $miembro->activo = 1; // O $miembro->esta_activo = true;
                $miembro->save();
                /*$pago->miembro->update([
                    'activo' => 1,
                ]);*/
            }

            // Puedes definir un estatus en tu tabla de miembros, por ejemplo, 'activo'
            // O una columna 'esta_activo' (booleano)
           // $miembro->estatus = 'activo'; // O $miembro->esta_activo = true;
           // $miembro->save();
        }
        
    }

    /**
     * Handle the Pago "updated" event.
     *
     * @param  \App\Models\Pago  $pago
     * @return void
     */
    public function updated(Pago $pago)
    {
        //
    }

    /**
     * Handle the Pago "deleted" event.
     *
     * @param  \App\Models\Pago  $pago
     * @return void
     */
    public function deleted(Pago $pago)
    {
        //
    }

    /**
     * Handle the Pago "restored" event.
     *
     * @param  \App\Models\Pago  $pago
     * @return void
     */
    public function restored(Pago $pago)
    {
        //
    }

    /**
     * Handle the Pago "force deleted" event.
     *
     * @param  \App\Models\Pago  $pago
     * @return void
     */
    public function forceDeleted(Pago $pago)
    {
        //
    }
}
