<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => 'Incorrect credentials'], 400);
            }
            $user = JWTAuth::user();
            $role = $user->role; 
            $id = $user->id; 

            $customClaims = ['role' => $role, 'id'=> $id];
            $token = JWTAuth::claims($customClaims)->attempt($credentials);
        }catch(Exception $e){
            return response()->json(['error' => 'no create token'], 500);
        }

        return response()->json(compact('token'));

    }
}
