<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Miembro extends Model
{
    use HasFactory;
    protected $fillable=["nombre","apellido","tel","edad","plan_id"];
    protected $hidden = ['created_at', 'updated_at', 'plan_id'];
    protected $casts = [
    'activo' => 'boolean',
    ];


    public function plan(){
        return $this->belongsTo(Plan::class);
    }

    public function pagos(){
        return $this->hasMany(Pago::class);
    }

     /**
     * Check if the user's last payment is not expired.
     *
     * @return bool True if the user has an active, unexpired subscription, false otherwise.
     */
    public function hasActiveSubscription(): bool{
        // Obtiene el último pago del usuario, ordenado por la fecha de pago más reciente.
        $lastPayment = $this->pagos()->latest('fecha_pago')->first();

        // Si no hay pagos, el usuario no tiene una suscripción activa.
        if (!$lastPayment) {
            return false;
        }

        // Si el pago no tiene una fecha de vencimiento (lo que no debería pasar con la lógica de booted()),
        // también lo consideramos inactivo o inválido para una suscripción.
        if (!$lastPayment->expira_en) {
            return false;
        }

        // Compara la fecha y hora actual con la fecha de vencimiento del último pago.
        // Si la fecha actual es ANTES de la fecha de vencimiento, el pago NO ha vencido.
        return Carbon::now()->lessThan($lastPayment->expira_en);
    }

    /**
     * Get the expiration date of the last payment.
     *
     * @return Carbon|null The expiration date as a Carbon instance, or null if no active subscription.
     */
    public function getSubscriptionExpirationDate(): ?Carbon{ //?indica que puede devolver null o una instancia de Carbon
    
        // Obtiene el último pago.
        $lastPayment = $this->pagos()->latest('fecha_pago')->first();

        // Retorna la fecha de vencimiento si existe, de lo contrario, null.
        return $lastPayment ? $lastPayment->expira_en : null;
    }

    /**
     * Get the details of the active plan.
     *
     * @return Plan|null The Plan model if there's an active subscription, otherwise null.
     */
    public function getActivePlan(): ?Plan{ //?indica que puede devolver null o una instancia de Plan
        $lastPayment = $this->pagos()->latest('fecha_pago')->first();

        // Si hay un último pago y está activo, retorna su plan asociado.
        if ($lastPayment && $this->hasActiveSubscription()) {
            return $lastPayment->plan; // Accede a la relación 'plan' del pago
        }

        return null;
    }

    /**
     * Get the details of plan even is not active.
     *
     * @return Plan
     */
    public function getPlan(): ?Plan{ //?indica que puede devolver null o una instancia de Plan

        return $this->plan; // Accede a la relación 'plan' del miembro
    }
}
