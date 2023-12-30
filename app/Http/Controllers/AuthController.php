<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request){
        
                $feilds = $request->validate([
                    'name'=>'required|string',
                    'email' =>'required|string|unique:users,email',
                    'password' => 'required|string|confirmed'
                ]);

                $user = User::create([
                    'name'=> $feilds['name'],
                    'email' => $feilds['email'],
                    'password' => bcrypt($feilds['password'])
                ]);

                $token = $user->createToken('myapptoken')->plainTextToken;

                $response = [
                    'user' => $user,
                    'token'=> $token
                ];

                return response($response,201);



    }

    public function logout(Request $request){
            auth()->user()->tokens()->delete();
    
            return [
                'message' => 'Logged out successfully'
            ];
      
    }


    public function login(Request $request){
        $feilds = $request->validate([
            'email' =>'required|string|',
            'password' => 'required|string'
        ]);

        //check email
        $user = User::where('email',$feilds['email'])->first();

        //check password
        if(!$user || !Hash::check($feilds['password'], $user->password)){
            return response([
                'message' =>'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token'=> $token
        ];

        return response($response,201);
    }
}
