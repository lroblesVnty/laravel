<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipoRequest;
use App\Models\Equipo;


class EquipoController extends Controller{

    public function index(){
        $equipos=Equipo::all();
        return $equipos;

    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreEquipoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipoRequest $request){
        $equipo=Equipo::create($request->all());
        return $equipo;
    }
}
