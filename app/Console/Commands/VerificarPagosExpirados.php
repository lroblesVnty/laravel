<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Miembro;
use Illuminate\Support\Facades\Log;

class VerificarPagosExpirados extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'memberships:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for expired memberships and deactivates members.';

   
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        $members = Miembro::where('activo', true)->where('id', '<>', 1)->get();

        foreach ($members as $member) {
            // Busca su último pago.
            $latestPayment = $member->pagos()->latest('expira_en')->first();
            //Log::info("latestPayment: ".$latestPayment );

            // Si el pago más reciente ha expirado, desactiva al miembro.
            if ($latestPayment && $latestPayment->expira_en->isPast()) {
                //$member->update(['activo' => false]);//*esto solo funciona si el campo es fillable
                
                $member->activo = false;
                // Guarda los cambios en la base de datos
                $member->save();
               // $this->info("Member {$member->id} has been deactivated due to expired payment.");
                //Log::info("Member {$member->id} has been deactivated due to expired payment.");
            }
        }

        //Log::info('Membership expiration check complete.');

        return 0;

    }
}
