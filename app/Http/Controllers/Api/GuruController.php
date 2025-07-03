<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::all();
        return response()->json($gurus);
    }

    public function show($id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return response()->json(['message' => 'Guru tidak ditemukan.'], 404);
        }

        return response()->json($guru);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'nip'            => 'required|string|unique:gurus,nip',
            'jenis_kelamin'  => 'required|in:Laki-Laki,Perempuan',
            'agama'          => 'required|string|max:50',
            'tempat_lahir'   => 'required|string|max:255',
            'tanggal_lahir'  => 'required|date',
            'alamat'         => 'required|string',
            'golongan_darah' => 'nullable|string|max:5',
            'status_nikah'   => 'required|string|max:50',
            'no_rekening'    => 'required|string|max:50',
            'nama_bank'      => 'required|string|max:50',
            'transportasi'   => 'nullable|string|max:255',
            'no_handphone'   => 'required|string|max:20',
            'user_id'        => 'nullable|exists:users,id',
        ]);

        $guru = Guru::create($request->all());

        return response()->json([
            'message' => 'Guru berhasil ditambahkan.',
            'guru' => $guru
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return response()->json(['message' => 'Guru tidak ditemukan.'], 404);
        }

        $request->validate([
            'nama_lengkap'   => 'sometimes|required|string|max:255',
            'nip'            => 'sometimes|required|string|unique:gurus,nip,' . $guru->id,
            'jenis_kelamin'  => 'sometimes|required|in:Laki-Laki,Perempuan',
            'agama'          => 'sometimes|required|string|max:50',
            'tempat_lahir'   => 'sometimes|required|string|max:255',
            'tanggal_lahir'  => 'sometimes|required|date',
            'alamat'         => 'sometimes|required|string',
            'golongan_darah' => 'nullable|string|max:5',
            'status_nikah'   => 'sometimes|required|string|max:50',
            'no_rekening'    => 'sometimes|required|string|max:50',
            'nama_bank'      => 'sometimes|required|string|max:50',
            'transportasi'   => 'nullable|string|max:255',
            'no_handphone'   => 'sometimes|required|string|max:20',
            'user_id'        => 'nullable|exists:users,id',
        ]);

        $guru->update($request->all());

        return response()->json([
            'message' => 'Guru berhasil diupdate.',
            'guru' => $guru
        ]);
    }

    
    public function destroy($id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return response()->json(['message' => 'Guru tidak ditemukan.'], 404);
        }

        $guru->delete();

        return response()->json(['message' => 'Guru berhasil dihapus.']);
    }
}
