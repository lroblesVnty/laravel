<?php

namespace App\Providers;

use App\Models\Asistencia;
use App\Models\Pago;
use App\Models\Visita;
use App\Observers\AsistenciaObserver;
use App\Observers\PagoObserver;
use App\Observers\VisitaObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        Carbon::setLocale(config('app.locale'));

        if (app()->environment('local')) {
            DB::listen(function ($query) {
                logger($query->sql);
            });
        }
        Pago::observe(PagoObserver::class);
        Visita::observe(VisitaObserver::class);
        Asistencia::observe(AsistenciaObserver::class);

    }
}
