<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:30|min:3',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validated->fails()) {
            return $this->response(400, $validated->getMessageBag()->first());
        }

        $create = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if ($create) {
            return $this->response(200, 'User is created successfully');
        }

        return $this->response(400, 'Something Wrong!');
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->all())) {
            $token = Auth::user()->createToken('auth_token');

            return response()->json([
                'message' => 'Login Successfully',
                'token' => $token->plainTextToken
            ], 200);
        }

        return $this->response(401, 'Username or Password is Wrong');
    }
}
