<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class ApiController extends Controller
{
    //register API (post, form-data)//
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);
        //Data save//
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //Response//
        return response()->json([
            "status" => true,
            "message" => "User created successfully"
        ]);
    }

    //login API (post, form-data)//
    public function login(Request $request) {

        //data validation//
        $request->validate([

            "email" => "required|email",
            "password" => "required",
        ]);
        //JWTAuth and attempt//
        $token = JWTAuth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if(!empty($token)) {

        // Response //
        return response()->json([
            "status" => true,
            "message" => "User logged in successfully",
            "token" => $token
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Invalid login Details",
            ]);
    }
    //Profile API (Get)//
    public function profile() {
        $userData = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "user" => $userData
            ]);
    }
    //refresh Token API (Get)//

    public function refreshToken() {
        $newToken = auth()->refresh();
        return response()->json([
            "status" => true,
            "message" => "New Access token generated",
            "token" => $newToken
            ]);
    }
    //logout API (Get)//
    public function logout() {
        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "User logged out successfully",
            ]);
    }
}
