<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMiembroRequest;
use App\Models\Miembro;
use Illuminate\Http\Request;

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
                'nombre'=>'required|string|max:150',
                'edad'=>'required|integer|max:100|gte:11',
            ]);
        }else{
            $request->validate([
                'nombre'=>'required|string|max:150',
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

    }

}
