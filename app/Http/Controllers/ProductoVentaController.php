<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ProductoVentaController extends Controller
{
    public function index(){
        $producto=Producto::all();
        $ventas=Venta::all();

    }
    public function show($id){
        
        try {
            //$venta=Venta::findOrFail($id)->productos()->get();
            $venta=Venta::findOrFail($id)->with('productos')->first();
            return $venta;
        } catch (ModelNotFoundException $e) {
            return response(['error' => true, 'message' => 'Sin coincidencias'],204);
            //return response(['error' => true, 'message' => 'Sin coincidencias']);
        }
    }
    public function store(Request $request){
        try {
            /*$venta=Venta::findOrFail($request->venta_id);
            $venta->productos()->attach($request->products_id);
            return $venta;*/
           //?$venta = Venta::findOrFail($request->venta_id)->create($request->all());
            //?$venta->buy()->attach($request->codecs);
            $venta=Venta::create($request->all());
            $venta->productos()->attach($request->products_id);
            return $venta;
        } catch (QueryException $e) {
            return response(['error' => true, 'message' => $e],409);
        }
    }


}
