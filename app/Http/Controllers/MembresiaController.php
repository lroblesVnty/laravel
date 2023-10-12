<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use Illuminate\Http\Request;

class MembresiaController extends Controller{

    public function index(){
        $miembros=Membresia::all();
        return $miembros;

    }

    public function store(Request $request){
        $request->validate([
            'nombre'=>'required|string|max:200|unique:membresias,nombre',
            'costo'=>'required|numeric|min:30',
        ]);
        $membresia=Membresia::create($request->all());
        return $membresia;
    }

    public function show($member){
        $miembro=Membresia::findOrFail($member);
        //$miembro=Miembro::findOrFail($member,['id','nombre']); visualizar solo id y nombre del miembro
        return $miembro;
    }

    public function destroy($member){
        $miembro=Membresia::findOrFail($member);
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
     * @param  \App\Models\Membresia  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$member){
        $miembro=Membresia::findOrFail($member);
        $request->validate([
            'nombre'=>'required|string|max:200',
            'costo'=>'required|numeric|min:30',
        ]);
       
        $miembro->nombre=$request->nombre;
        $miembro->edad=$request->edad;
        $miembro->tel=$request->tel;
        $miembro->save();
       
        //return  $miembro->getChanges();
        return  $miembro;

    }

}
