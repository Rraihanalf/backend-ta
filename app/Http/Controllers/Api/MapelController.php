<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = Mapel::all();
        return response()->json($mapels);
    }

    public function show($id)
    {
        $mapel = Mapel::find($id);

        if (!$mapel) {
            return response()->json(['message' => 'Mapel tidak ditemukan.'], 404);
        }

        return response()->json($mapel);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:100',
            'kelas' => 'required|string|max:10',
            'tahun_ajar' => 'required|string|max:20',
        ]);

        $mapel = Mapel::create([
            'nama_mapel' => $request->nama_mapel,
            'kelas' => $request->kelas,
            'tahun_ajar' => $request->tahun_ajar,
        ]);

        return response()->json([
            'message' => 'Mapel berhasil ditambahkan.',
            'data' => $mapel,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $mapel = Mapel::find($id);

        if (!$mapel) {
            return response()->json(['message' => 'Mapel tidak ditemukan.'], 404);
        }

        $request->validate([
            'nama_mapel' => 'required|string|max:100',
            'kelas' => 'required|string|max:10',
            'tahun_ajar' => 'required|string|max:20',
        ]);

        $mapel->update([
            'nama_mapel' => $request->nama_mapel,
            'kelas' => $request->kelas,
            'tahun_ajar' => $request->tahun_ajar,
        ]);

        return response()->json([
            'message' => 'Mapel berhasil diperbarui.',
            'data' => $mapel,
        ]);
    }

    public function destroy($id)
    {
        $mapel = Mapel::find($id);

        if (!$mapel) {
            return response()->json(['message' => 'Mapel tidak ditemukan.'], 404);
        }

        $mapel->delete();

        return response()->json(['message' => 'Mapel berhasil dihapus.']);
    }
}
