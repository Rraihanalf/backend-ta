<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GuruPengampu;
use Illuminate\Http\Request;

class GuruPengampuController extends Controller
{
    public function index()
    {
        $pengampus = GuruPengampu::with(['guru', 'mapel'])->get();
        return response()->json($pengampus);
    }

    public function show($id)
    {
        $pengampu = GuruPengampu::with(['guru', 'mapel'])->find($id);

        if (!$pengampu) {
            return response()->json(['message' => 'Data pengampu tidak ditemukan.'], 404);
        }

        return response()->json($pengampu);
    }

    public function byMapel(Request $request)
    {
        $mapelId = $request->query('mapel_id');

        if (!$mapelId) {
            return response()->json(['message' => 'mapel_id is required'], 400);
        }

        $data = GuruPengampu::with('guru')
            ->where('mapel_id', $mapelId)
            ->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajar' => 'required|string|max:20',
            'guru_id' => 'nullable|exists:gurus,id',
            'mapel_id' => 'nullable|exists:mapels,id',
        ]);

        $pengampu = GuruPengampu::create($request->all());

        return response()->json([
            'message' => 'Data pengampu berhasil ditambahkan.',
            'data' => $pengampu,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $pengampu = GuruPengampu::find($id);

        if (!$pengampu) {
            return response()->json(['message' => 'Data pengampu tidak ditemukan.'], 404);
        }

        $request->validate([
            'tahun_ajar' => 'sometimes|required|string|max:20',
            'guru_id' => 'nullable|exists:gurus,id',
            'mapel_id' => 'nullable|exists:mapels,id',
        ]);

        $pengampu->update($request->all());

        return response()->json([
            'message' => 'Data pengampu berhasil diperbarui.',
            'data' => $pengampu,
        ]);
    }

    public function destroy($id)
    {
        $pengampu = GuruPengampu::find($id);

        if (!$pengampu) {
            return response()->json(['message' => 'Data pengampu tidak ditemukan.'], 404);
        }

        $pengampu->delete();

        return response()->json(['message' => 'Data pengampu berhasil dihapus.']);
    }
}
