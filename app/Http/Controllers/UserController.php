<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request){
            $fields = $request->validate([
                "username" => "required|string",
                "email" => "required|string|unique:users,email",
                "password" => "required|string|confirmed"
            ]);

           $user =  User::create([
                "username" => $fields['username'],
                "email" => $fields['email'],
                "password" => bcrypt($fields['password'])
            ]);

           $token = $user->createToken('myusertoken')->plainTextToken;

           $response = [
            "user" => $user,
            "token" => $token,
            "message" => 'Successfully created a user.'
           ];

           return response($response, 201);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return ['message' => 'Successfully logout'];
    }

    public function login(Request $request){
        $fields = $request->validate([
            "email" => "required|string",
            "password" => "required|string"
        ]);

        $user = User::where('email', $fields['email'])->first();
        if(!$user || !Hash::check($fields['password'] , $user->password )){
                return ['failed' => 'Bad credentials'];
        }

        $token = $user->createToken('mytoken123')->plainTextToken;
        $response = [
            "user" => $user,
            "token" => $token,
            "message" => 'Successfully logged-in user.'
           ];

           return response($response, 201);
        
    }
}
