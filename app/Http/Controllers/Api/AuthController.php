<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\HashController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            //app('user')->setuser($user);
            //$request->session()->put('user', $user);
            Cache::put('user', $user, 14400); 
            //$user2=app('user')->getuser();
        
            //$request->session()->regenerate();
            return response()->json([
                'user' => $user,
                
                'authorization' => [
                    'token' => $user->createToken('ApiToken')->plainTextToken,
                    'type' => 'bearer',
                ]
            ]);
        }
        
        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $api_access=false;
        if(isset($request->hash)){
           if($request->hash==env('EDITOR_CODE')){
            $api_access=true;
           }
        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_access'=>$api_access,
        ]);
        if ($api_access){
            $hash_create=app('hash_controller')->gethash($user);
            if($hash_create['success']){
                return response()->json([
                    'message' => 'User created successfully, keep this hash',
                    'user' => $user,
                    'hash'=>$hash_create,
                    
                ]);
            }
            else{
                return response()->json([
                    'message' => 'User created successfully',
                    'user' => $user,
                    
                ]);
            }
            
        }
        else{
            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
                
            ]);
        }
        
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    

}
