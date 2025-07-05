<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\MiembroController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductoVentaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::apiResource("estudiantes",EstudiantesController::class);

Route::apiResource('productos',ProductoController::class)->except([
    'create', 'edit'
]); 

Route::apiResource('sales',VentaController::class)->except([
    'create', 'edit'
]);

Route::apiResource('proveedor',ProveedorController::class)->except([
    'create', 'edit'
]); 

Route::apiResource('equipo',EquipoController::class)->except([
    'create', 'edit'
]);

Route::apiResource('miembro',MiembroController::class)->except([
    'create', 'edit'
]); 

Route::apiResource('membresia',MembresiaController::class)->except([
    'create', 'edit'
]);

Route::apiResource('pago',PagoController::class)->except([
    'create', 'edit'
]); 


Route::get('plan',[PlanController::class,'index']);
Route::post('plan',[PlanController::class,'store']);

//Route::get("estudiantes",[EstudiantesController::class,'index']);
Route::get('ventas/{id}',[ProductoVentaController::class,'show']);
Route::post('ventas',[ProductoVentaController::class,'store']);
Route::get('ventas',[ProductoVentaController::class,'index']);
Route::get('ventasTotal',[ProductoVentaController::class,'totByDate']);

Route::post("/register",[UserController::class,'register']);
Route::post("login",[UserController::class,'login']);
Route::get("users",[UserController::class,'index']);

Route::get("miembro/{id}/status",[MiembroController::class,'checkStatusPlan']);
Route::get("status/miembro",[MiembroController::class,'statusMembers']);

Route::get("miembros/plan",[MiembroController::class,'plan']);



//Route::post("file/upload",[FileController::class,'store']);
Route::get("file/view/{image}",[FileController::class,'find']);
Route::apiResource('file',FileController::class)->except([
    'create', 'edit'
]); 



Route::group(['middleware'=>["auth:sanctum"]],function(){
    Route::get('user-profile',[UserController::class,'userProfile']);
    Route::get('logout',[UserController::class,'logout']);
});

/*Route::group(['prefix'=>'admin','middleware'=>["auth:sanctum"]],function(){//prefix is for each route =/admin/user-profile
    Route::get('user-profile',[UserController::class,'userProfile']);
    Route::get('logout',[UserController::class,'logout']);
});*/
