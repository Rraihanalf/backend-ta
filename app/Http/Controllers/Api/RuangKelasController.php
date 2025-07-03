<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RuangKelas;
use Illuminate\Http\Request;

class RuangKelasController extends Controller
{
    public function index()
    {
        $kelas = RuangKelas::with('guru')->withCount('siswa')->get(); // include wali kelas
        return response()->json($kelas);
    }

    public function show($id)
    {
        $kelas = RuangKelas::with('guru')->find($id);

        if (!$kelas) {
            return response()->json(['message' => 'Kelas tidak ditemukan.'], 404);
        }

        return response()->json($kelas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajar' => 'required|string|max:20',
            'nama_kelas' => 'required|string|max:100',
            'guru_id'    => 'nullable|exists:gurus,id',
        ]);

        $kelas = RuangKelas::create($request->all());

        return response()->json([
            'message' => 'Kelas berhasil ditambahkan.',
            'data' => $kelas
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $kelas = RuangKelas::find($id);

        if (!$kelas) {
            return response()->json(['message' => 'Kelas tidak ditemukan.'], 404);
        }

        $request->validate([
            'tahun_ajar' => 'sometimes|required|string|max:20',
            'nama_kelas' => 'sometimes|required|string|max:100',
            'guru_id'    => 'nullable|exists:gurus,id',
        ]);

        $kelas->update($request->all());

        return response()->json([
            'message' => 'Kelas berhasil diperbarui.',
            'data' => $kelas
        ]);
    }

    public function destroy($id)
    {
        $kelas = RuangKelas::find($id);

        if (!$kelas) {
            return response()->json(['message' => 'Kelas tidak ditemukan.'], 404);
        }

        $kelas->delete();

        return response()->json(['message' => 'Kelas berhasil dihapus.']);
    }
}
