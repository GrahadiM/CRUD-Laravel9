<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['nullable', 'string', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 422);

        $data = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ])->syncRoles([2]);

        Log::info('Mendaftarkan Akun!');

        return new UserResource(true, 'Register Berhasil!!', $data);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 422);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Login Berhasil')->accessToken;
                $response = ['token' => $token];
                Log::info('Pengguna Dengan Email ' . $user->email . 'Telah Login!');
                return new UserResource(true, 'Login Berhasil!', $response);
            } else {
                $response = ["message" => "Password Tidak Sesuai!"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User Tidak Ditemukan!'];
            return response($response, 422);
        }
    }

    public function logout (Request $request) {
        if ($request->user()) {
            $request->user()->token()->revoke();
            $request->user()->token()->delete();
        }
        $response = ['message' => 'Logout Berhasil!'];
        Log::info('Pengguna Telah Logout!');
        return response($response, 200);
    }
}
