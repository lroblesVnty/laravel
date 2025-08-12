<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pago extends Model
{
    use HasFactory;
    protected $fillable=["fecha_pago","expira_en","miembro_id","plan_id","metodo_pago","monto"];
    protected $dates = ['fecha_pago','expira_en',];
    protected $hidden = ['created_at', 'updated_at'];

    public function miembro(){
        return $this->belongsTo(Miembro::class);
    }

     public function plan(){
        return $this->belongsTo(Plan::class);
    }


    protected static function booted(){
        //**FUNCION PARA CALCULAR LA FECHA DE EXPIRACION */
        static::creating(function (Pago $payment) {
            if (!$payment->fecha_pago) {
                $payment->fecha_pago = Carbon::now();
            }
            if ($payment->plan && $payment->plan->duracion_dias !== null) {
                // Sumamos directamente la cantidad de días del campo 'duracion_dias'
                $payment->expira_en = $payment->fecha_pago->addDays($payment->plan->duracion_dias);
            } else {
                // Manejar el caso donde el plan no tiene una duración definida
                $payment->expira_en = null; // O un valor por defecto
            }
        });
    }


   
}
