<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NilaiSiswa;
use Illuminate\Http\Request;

class NilaiSiswaController extends Controller
{
    public function index()
    {
        $nilai = NilaiSiswa::with(['siswa', 'mapel'])->get();
        return response()->json($nilai);
    }

    public function show($id)
    {
        $nilai = NilaiSiswa::with(['siswa', 'mapel'])->find($id);

        if (!$nilai) {
            return response()->json(['message' => 'Data nilai tidak ditemukan.'], 404);
        }

        return response()->json($nilai);
    }

    public function store(Request $request)
    {
        $request->validate([
            'mapel_id'    => 'required|exists:mapels,id',
            'siswa_id'    => 'required|exists:siswas,id',
            'nilai'       => 'required|numeric|min:0|max:100',
            'semester'    => 'required|string|max:10',
            'tahun_ajar'  => 'required|string|max:9',
        ]);

        $exists = NilaiSiswa::where([
            'mapel_id'   => $request->mapel_id,
            'siswa_id'   => $request->siswa_id,
            'semester'   => $request->semester,
            'tahun_ajar' => $request->tahun_ajar,
        ])->first();

        if ($exists) {
            return response()->json([
                'message' => 'Data nilai untuk kombinasi ini sudah ada.'
            ], 409);
        }

        $nilai = NilaiSiswa::create($request->all());

        return response()->json([
            'message' => 'Data nilai berhasil ditambahkan.',
            'data' => $nilai,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $nilai = NilaiSiswa::find($id);

        if (!$nilai) {
            return response()->json(['message' => 'Data nilai tidak ditemukan.'], 404);
        }

        $request->validate([
            'mapel_id'    => 'sometimes|required|exists:mapels,id',
            'siswa_id'    => 'sometimes|required|exists:siswas,id',
            'nilai'       => 'sometimes|required|numeric|min:0|max:100',
            'semester'    => 'sometimes|required|string|max:10',
            'tahun_ajar'  => 'sometimes|required|string|max:9',
        ]);

        $nilai->update($request->all());

        return response()->json([
            'message' => 'Data nilai berhasil diperbarui.',
            'data' => $nilai,
        ]);
    }

    public function destroy($id)
    {
        $nilai = NilaiSiswa::find($id);

        if (!$nilai) {
            return response()->json(['message' => 'Data nilai tidak ditemukan.'], 404);
        }

        $nilai->delete();

        return response()->json(['message' => 'Data nilai berhasil dihapus.']);
    }
}
