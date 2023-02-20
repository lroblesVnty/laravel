<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller{
    public function index(){
        $users=User::all();
        return $users;
    }
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'            
        ]);
        //$user=User::create($request->all());
        $user= new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password = Hash::make($request->password);//encriptar password
        $user->save();
        //return response()->json(["status"=>1,"msg"=>"Registro exitoso"]);
        return response(['error' => false, 'msg' => 'Registro exitoso'],201);
        
    }
    public function login(Request $request){
        $credentials=$request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        /*$user=User::where("email","=",$request->email)->first();
        if (isset($user->id)) {
            if (Hash::check($request->password,$user->password)) {
                //crear el token
                $token=$user->createToken("auth_token")->plainTextToken;
                return response()->json(["error"=>false,"msg"=>"Login exitoso","access_token"=>$token],200);

            }else{
                return response()->json(["error"=>true,"msg"=>"Email o Password incorrectos"],401);
            }
        }else{
            return response()->json(["error"=>true,"msg"=>"Email o Password incorrectos"],401);
        }*/
        if (!Auth::attempt($credentials)) {
            return response()->json(["error"=>true,"msg"=>"Email o Password incorrectos"],401);
        }
        /** @var \App\Models\User $user **/
        $user=Auth::user();
        $token=$user->createToken('auth-token')->plainTextToken;
        $cookie=cookie('cookie_token',$token,60*24); //60*24= expiracion

        return response()->json(["error"=>false,"msg"=>"Login exitoso","data"=>auth()->user(),"access_token"=>$token],200)->withCookie($cookie);

    
    }
    public function userProfile(){
        
        return response()->json(["error"=>false,"data"=>auth()->user()],200);
    
    }
    public function logout(User $user){
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $user->tokens()->delete();
    
       // auth()->user()->tokens()->delete();
        $cookie = Cookie::forget('cookie_token');
        return response()->json(["error"=>false,"msg"=>"Logout exitoso"])->withCookie($cookie);

    }
    
}
