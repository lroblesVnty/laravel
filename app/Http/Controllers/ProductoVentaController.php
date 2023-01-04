<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use PHPUnit\Util\Json;

class ProductoVentaController extends Controller
{
    public function index(){
        //$producto=Producto::all();
        //$ventas=Venta::all();
        $ventas=Venta::with('productos')->get();
        return $ventas;

    }
    public function show($id){
        
        try {
            //$venta=Venta::findOrFail($id)->productos()->get();
           $venta=Venta::findOrFail($id)->with('productos')->first();
          
            return  $venta;
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
            $products_id=$request->products_id;
            for($i=0 ; $i<count( $products_id) ; $i++){
                $venta->productos()->attach($products_id[$i],[ 'producto_cantidad'=>$request->cantidad[$i] ]);
            }
           
            //$venta->productos()->attach($request->products_id,['producto_cantidad' => $request->cantidad]);
          
            //$venta->productos()->attach($products_id);

           /* $count_each_food_mapped = array_map(function ($item) {
                return ['count' => $item];
            }, $request->cantidad);*/
          

            return $venta;
        } catch (QueryException $e) {
            return response(['error' => true, 'message' => $e],409);
        }
    }


}
