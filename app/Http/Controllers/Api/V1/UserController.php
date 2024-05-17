<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validatedUser = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
            ]);
    
            if ($validatedUser->fails()) {
                return response()->json(['message' => 'Registration failed', 'error' => $validatedUser->errors()], 500);
            }
    
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
            ]);
    
            return response()->json(['message' => 'Registration was successful', 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Registration failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validatedUser = Validator::make($request->all(),[
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);
    
            if ($validatedUser->fails()) {
                return response()->json(['message' => 'Login failed', 'error' => $validatedUser->errors()], 500);
            }
    
            if(!auth()->attempt($request->only('email', 'password'))) {
                return response()->json(['message' => 'Email or password does not match with our record'], 401);
            }
    
            $user = User::where('email', $request->email)->first();
    
            return response()->json(['message' => 'Login successful', 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Login failed', 'error' => $e->getMessage()], 500);
        }
    }
}
