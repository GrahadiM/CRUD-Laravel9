<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        Auth::check();
        $data = User::latest('id')->get();

        Log::info('Melihat List Pengguna!');

        return new UserResource(true, 'List Data Users', $data);
    }

    public function store(Request $request)
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

        Log::info('Membuat Pengguna Baru!');

        return new UserResource(true, 'Data Berhasil Ditambahkan!', $data);
    }

    public function show(User $user)
    {
        if ($user->id == NULL)
            abort(404);

        Log::info('Melihat Detail Pengguna! ID :' . $user->id);

        return new UserResource(true, 'Data Ditemukan!', $user);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 422);

        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['updated_at'] = now();

        if ($request->email != $user->email)
            $data['email'] = $request->email;

        if ($request->username != $user->username)
            $data['username'] = $request->username;

        if ($request->password != $user->password)
            $data['password'] = Hash::make($request->password);

        $user->update($data);

        Log::info('Mengubah Data Pengguna! ID :' . $user->id);

        return new UserResource(true, 'Data Berhasil Diupdate!', $user);
    }

    public function destroy(User $user)
    {
        Log::info('Menghapus Data Pengguna! ID :' . $user->id);
        $user->delete();

        return new UserResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}
