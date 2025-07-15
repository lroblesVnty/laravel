<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMiembroRequest;
use App\Models\Miembro;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MiembroController extends Controller{
    
    public function index(){
        $miembros=Miembro::all();
        return $miembros;

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMiembroRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMiembroRequest $request){
        $member=Miembro::create($request->all());
        return $member;
    }

    public function show($member){
        $miembro=Miembro::findOrFail($member);
        //$miembro=Miembro::findOrFail($member,['id','nombre']); visualizar solo id y nombre del miembro
        return $miembro;
    }

    public function destroy($member){
        $miembro=Miembro::findOrFail($member);
        $del=$miembro->delete();
        //$miembro=Miembro::destroy($miembro); otra manera de borrar
        if ($del>=1) {
            return response(['success' => true, 'message' => 'Eliminado exitosamente'],200);
        }
        return $miembro;
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Miembro  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$member){
        $miembro=Miembro::findOrFail($member);
        if ( $miembro->tel==$request->tel) {
            $request->validate([
                'nombre'=>'required|string|max:150|min:3|regex:/^[a-zA-ZÁ-ÿ\s]+$/',
                'edad'=>'required|integer|max:100|gte:11',
            ]);
        }else{
            $request->validate([
                'nombre'=>'required|string|max:150|min:3|regex:/^[a-zA-ZÁ-ÿ\s]+$/',
                'tel'=>'required|integer|digits:10|unique:miembros,tel',
                'edad'=>'required|integer|max:100|gte:11',
            ]);
        }
       
        $miembro->nombre=$request->nombre;
        $miembro->edad=$request->edad;
        $miembro->tel=$request->tel;
        $miembro->save();
       
        //return  $miembro->getChanges();
        return  $miembro;

        //patch maybe can
        //Tax::findOrFail($id)->update($request->only('description'))

    }
    
    public function checkStatusPlan($id){
        $miembro=Miembro::findOrFail($id);
        $expirationDate = $miembro->getSubscriptionExpirationDate();
        $activePlan = $miembro->getActivePlan();
        $isActive=false;
        if ($miembro->activo) {
            $isActive=true;
        } 


        return response()->json([
                'miembro' => $miembro,
                'isActive' => $isActive,
                'expirationDate' => $expirationDate->format('d/m/Y H:i:s'),
                'plan' => $activePlan->nombre_plan,
                //'plan' => $activePlan,
        ]);
        //return $resp;

        //>pagos()->where('fecha_pago', '<', $date)->get()
    }

    public function statusMembers(){
       
        //return Miembro::with('plan:id,nombre_plan')->get();
       


        
        return Miembro::all()->map(function ($miembro) {
            $miembro->plan=$miembro->getActivePlan();
            //$activePlan = $miembro->getActivePlan();
            //$miembro->plan=$activePlan['nombre_plan'];
            $miembro->expirationDate=$miembro->getSubscriptionExpirationDate();
            return $miembro;
        });

       // return Miembro::with('plan')->get();

       /*  $latestPosts = DB::table('pagos')
        ->select('miembro_id', DB::raw('MAX(fecha_pago) as lastPayDate'))
        ->groupBy('miembro_id'); */

      
    }

    public function plan() {

        return Miembro::select(['miembros.id','miembros.nombre','membresias.nombre as tipo'])
         ->join('plans', 'miembros.id', '=', 'plans.miembro_id')
         ->join('membresias', 'membresias.id', '=', 'plans.membresia_id')->get();
        
         //*otra opcion para obtener el nombre de la membresia del usuario
         //TODO quitar la tabla membresias y dejar solo la de planes
        Miembro::with(['plan.membresia'])
            ->get()
            ->map(function ($miembro) {
                return [
                    'id' => $miembro->id,
                    'nombre' => $miembro->tel,
                    'tel' => $miembro->nombre,
                    'tipo_membresia' => optional($miembro->plan->membresia)->nombre,
                ];
        });

        Miembro::with([
                'plan.membresia' => function ($query) {
                    $query->select('id', 'nombre', 'costo');
                }
            ])->get(['id', 'nombre', 'tel', 'edad']);

       
    }

     /**
     * Muestra el estado de la suscripción de un usuario.
     *
     * @param  \App\Models\Miembro  $miembro
     * @return \Illuminate\Http\Response
     */
    public function showSubscriptionStatus(Miembro $miembro){
        if ($miembro->hasActiveSubscription()) {
            $expirationDate = $miembro->getSubscriptionExpirationDate();
            $activePlan = $miembro->getActivePlan();

            return response()->json([
                'miembro' => $miembro,
                'isActive' => true,
                'expirationDate' => $expirationDate->format('d/m/Y H:i:s'),
                'plan' => $activePlan->nombre_plan,
                //'plan' => $activePlan,
            ]);
        } else {
            return response()->json([
                'miembro' => $miembro,
                'isActive' => false,
            ]);
        }
    }

}
