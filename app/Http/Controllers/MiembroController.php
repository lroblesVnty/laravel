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
    
    public function checkStatusPlan($member){
        $date=today()->format('Y-m-d');
        $miembro=Miembro::findOrFail($member);
        //$resp=$miembro->pagos()->where('fecha_pago', '<', $date)->get();
        /*$resp=DB::table('pagos')
        ->where('miembro_id', '=', $member)
        ->whereDate('fecha_pago','<', $date)
        ->get();*/
        $resp=DB::table('pagos')
        //>selectRaw('max(fecha_pago) as lastPayDate')
        ->select(DB::raw('date_format(max(fecha_pago),"%d-%M-%Y")as lastPayDate'))
        ->where('miembro_id', '=', $member)
        ->groupBy('miembro_id')
        ->havingRaw('DATE(max(fecha_pago))<?', [$date])
        ->get();
        //return $resp;
        setlocale(LC_TIME, 'es_ES.UTF-8'); 
        Carbon::setLocale('es');
        //$lastPayDate = Carbon::parse($resp[0]->lastPayDate)->format('d-F-Y');
        $lastPayDate= Carbon::parse($resp[0]->lastPayDate)->isoFormat('D\-MMMM\-Y');

        $count = $resp->count();
        if ($count==0) {
            return response(['success'=>true,'status'=>'plan activo']);
        }
        return response(['success'=>false,'status'=>'inactivo','lastPayDate'=>$lastPayDate]);
        //return $resp;

        //>pagos()->where('fecha_pago', '<', $date)->get()
    }

}
