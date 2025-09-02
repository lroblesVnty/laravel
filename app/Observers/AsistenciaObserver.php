<?php

namespace App\Observers;

use App\Exceptions\MiembroInactivoException;
use App\Models\Asistencia;
use App\Models\Miembro;
use Illuminate\Validation\ValidationException;

class AsistenciaObserver{
    //php artisan make:observer AsistenciaObserver --model=Asistencia //?crear observer
    //?se tiene que registrar en el archivo AppServiceProvider.php */

     /**
     * Handle the Asistencia "creating" event.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return void
     */
    public function creating(Asistencia $asistencia){
        $miembro = Miembro::find($asistencia->miembro_id);

        if (!$miembro || !$miembro->activo) {
            throw new MiembroInactivoException();

           /*  throw ValidationException::withMessages([
                'miembro_id' => 'El miembro no está activo. No se puede registrar asistencia.',
            ]); */
        }
    }




    /**
     * Handle the Asistencia "created" event.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return void
     */
    public function created(Asistencia $asistencia)
    {
        //
    }

    /**
     * Handle the Asistencia "updated" event.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return void
     */
    public function updated(Asistencia $asistencia)
    {
        //
    }

    /**
     * Handle the Asistencia "deleted" event.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return void
     */
    public function deleted(Asistencia $asistencia)
    {
        //
    }

    /**
     * Handle the Asistencia "restored" event.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return void
     */
    public function restored(Asistencia $asistencia)
    {
        //
    }

    /**
     * Handle the Asistencia "force deleted" event.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return void
     */
    public function forceDeleted(Asistencia $asistencia)
    {
        //
    }
}
