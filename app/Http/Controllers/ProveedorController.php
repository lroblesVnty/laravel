<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller{

    public function index(){
        $providers=Proveedor::all();
        return $providers;

    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $proveedor=Proveedor::create($request->all());
        return $proveedor;
    }
}
