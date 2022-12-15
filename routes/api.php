<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductoVentaController;
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
//Route::get("estudiantes",[EstudiantesController::class,'index']);
Route::get('ventas/{id}',[ProductoVentaController::class,'show']);
Route::post('ventas',[ProductoVentaController::class,'store']);

Route::post("/register",[UserController::class,'register']);
Route::post("login",[UserController::class,'login']);
Route::group(['middleware'=>["auth:sanctum"]],function(){
    Route::get('user-profile',[UserController::class,'userProfile']);
    Route::get('logout',[UserController::class,'logout']);
});
