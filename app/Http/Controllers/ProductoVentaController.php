<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoVentaRequest;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use PHPUnit\Util\Json;
use Illuminate\Support\Facades\DB;

class ProductoVentaController extends Controller
{
    public function index(){
        //$prodStock=Producto::all();
        //$ventas=Venta::all();
        $ventas=Venta::with('productos','user:id,name')->get(['id','created_at AS fecha_venta','total','user_id']);
       // $ventas=Venta::with('productos','user')->get(['id','created_at AS fecha_venta','total','user_id']);
       
        return $ventas;

    }
    public function show($id){
        
        try {
           //$venta=Venta::findOrFail($id)->productos()->get();
           // $venta=Venta::findOrFail($id)->with('productos');
            $venta=Venta::with('productos','user:id,name')->findOrFail($id,['id','created_at as fecha_venta','total','user_id']);
          
          
            return  $venta;
        } catch (ModelNotFoundException $e) {
            return response(['error' => true, 'message' => $e],204);
            //return response(['error' => true, 'message' => 'Sin coincidencias']);
        }
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductoVentaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductoVentaRequest $request){
        try {
            /*$venta=Venta::findOrFail($request->venta_id);
            $venta->productos()->attach($request->products_id);
            return $venta;*/
            foreach($request->products as $key=>$val){
                //$prodStock=Producto::findOrFail($key)->first()->stock;
                $product=Producto::findOrFail($key)->first(['stock','descripcion']);
                $prodStock=$product->stock;
                $prodName=$product->descripcion;
                if (!($prodStock>=0 && $prodStock>=(int) $val['producto_cantidad'])) {
                    return response(['success'=>false,'msg'=>'Producto "'.$prodName.'" agotado'],409);
                }

            }
           //?$venta = Venta::findOrFail($request->venta_id)->create($request->all());
            //?$venta->buy()->attach($request->codecs);
            $venta=Venta::create($request->all());
            /*$products_id=$request->products_id;
            for($i=0 ; $i<count( $products_id) ; $i++){
                $venta->productos()->attach($products_id[$i],[ 'producto_cantidad'=>$request->cantidad[$i] ]);
            }*/
            $venta->productos()->attach($request->products);
            /*Producto::where('id', $request->products)
            ->update([
                "stock" => DB::table('producto_venta')->select('producto_cantidad')->where('producto_cantidad',)
            ]);*/
           
            foreach($request->products as $key=>$val){
                
                Producto::where('id', $key)
                ->decrement('stock', (int) $val['producto_cantidad']);
                /*->update([
                    "stock" => $val['producto_cantidad']->select(DB::raw('count(*) as user_count, status'))
                    ->where('status', '<>', 1)
                ]);*/
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
