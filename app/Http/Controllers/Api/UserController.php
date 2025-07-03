<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        return response()->json($user);
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'role'     => 'required|in:wali,admin,guru',
                'password' => 'required|min:6',
            ]);
    
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'role'     => $request->role,
                'password' => Hash::make($request->password),
            ]);
    
            return response()->json([
                'message' => 'User berhasil dibuat.',
                'user'    => $user
            ], 201);

        }catch (\Exception $e) {
            return response()->json([
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'email'    => 'sometimes|required|email|unique:users,email,' . $user->id,
            'role'     => 'sometimes|required|in:wali,admin,guru',
            'password' => 'sometimes|min:6',
        ]);

        $user->update([
            'name'     => $request->name ?? $user->name,
            'email'    => $request->email ?? $user->email,
            'role'     => $request->role ?? $user->role,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json([
            'message' => 'User berhasil diupdate.',
            'user'    => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus.']);
    }
}
