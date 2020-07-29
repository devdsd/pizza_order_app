<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required|max:55',
        //     'email' => 'email|required|unique:users',
        //     'password' => 'required|confirmed'
        // ]);

        // $validatedData['password'] = bcrypt($request->password);

        // $user = User::create($validatedData);

        // $accessToken = $user->createToken('authToken')->accessToken;

        // return response([ 'user' => $user, 'access_token' => $accessToken]);

        // New Code
        $request->Validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed']
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            // 'email' => 'email|required',
            'email' => ['required', 'email'],
            // 'password' => 'required'
            'password' => ['required']
        ]);

        // if (!auth()->attempt($loginData)) {
        //     return response(['message' => 'Invalid Credentials']);
        // }

        // $accessToken = auth()->user()->createToken('authToken')->accessToken;

        // return response(['user' => auth()->user(), 'access_token' => $accessToken]);

        // New Code
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect!']
            ]);
        }

        $accessToken = $user->createToken('authToken')->accessToken;

        return $accessToken;
        // return response(['user' => $user, 'access_token' => $accessToken]);
    }


    public function logout (Request $request) {

        $request->user()->token()->delete();
    }
}
