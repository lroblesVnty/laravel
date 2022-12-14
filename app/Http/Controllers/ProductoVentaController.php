<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductoVentaController extends Controller
{
    public function index(){
        $producto=Producto::all();
        $ventas=Venta::all();

    }
    public function show($id)
    {
        
        try {
            //$venta=Venta::findOrFail($id)->productos()->get();
            $venta=Venta::findOrFail($id)->with('productos')->first();
            return $venta;
        } catch (ModelNotFoundException $e) {
            return response(['error' => true, 'message' => 'Sin coincidencias'],204);
            //return response(['error' => true, 'message' => 'Sin coincidencias']);
        }
    }

}
