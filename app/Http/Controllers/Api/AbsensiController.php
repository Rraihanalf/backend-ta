<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $data = Absensi::with(['jadwal', 'siswa'])->get();
        return response()->json($data);
    }

    public function show($id)
    {
        $absensi = Absensi::with(['jadwal', 'siswa'])->find($id);

        if (!$absensi) {
            return response()->json(['message' => 'Data absensi tidak ditemukan.'], 404);
        }

        return response()->json($absensi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_pelajarans,id',
            'siswa_id'  => 'required|exists:siswas,id',
            'status'    => 'required|in:hadir,izin,sakit,alfa',
        ]);

        $exists = Absensi::where([
            'jadwal_id' => $request->jadwal_id,
            'siswa_id'  => $request->siswa_id,
        ])->first();

        if ($exists) {
            return response()->json(['message' => 'Data absensi sudah tercatat.'], 409);
        }

        $absensi = Absensi::create($request->all());

        return response()->json([
            'message' => 'Data absensi berhasil ditambahkan.',
            'data'    => $absensi,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $absensi = Absensi::find($id);

        if (!$absensi) {
            return response()->json(['message' => 'Data absensi tidak ditemukan.'], 404);
        }

        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alfa',
        ]);

        $absensi->update($request->only('status'));

        return response()->json([
            'message' => 'Data absensi berhasil diperbarui.',
            'data' => $absensi,
        ]);
    }

    public function destroy($id)
    {
        $absensi = Absensi::find($id);

        if (!$absensi) {
            return response()->json(['message' => 'Data absensi tidak ditemukan.'], 404);
        }

        $absensi->delete();

        return response()->json(['message' => 'Data absensi berhasil dihapus.']);
    }
}
