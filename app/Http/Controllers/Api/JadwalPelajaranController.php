<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;

class JadwalPelajaranController extends Controller
{
    public function index()
    {
        $jadwal = JadwalPelajaran::with(['kelas', 'mapel', 'guru'])->get();
        return response()->json($jadwal);
    }

    public function show($id)
    {
        $jadwal = JadwalPelajaran::with(['kelas', 'mapel', 'guru'])->find($id);

        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal tidak ditemukan.'], 404);
        }

        return response()->json($jadwal);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:ruang_kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id'  => 'required|exists:gurus,id',
            'hari'     => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $hari = $request->hari;
        $jamMulai = $request->jam_mulai;
        $jamSelesai = $request->jam_selesai;
        $kelasId = $request->kelas_id;
        $guruId = $request->guru_id;

        $conflictGuru = JadwalPelajaran::where('hari', $hari)
            ->where('guru_id', $guruId)
            ->where(function ($query) use ($jamMulai, $jamSelesai) {
                $query->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                    ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai])
                    ->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                        $q->where('jam_mulai', '<=', $jamMulai)
                            ->where('jam_selesai', '>=', $jamSelesai);
                    });
            })->exists();

        if ($conflictGuru) {
            return response()->json([
                'message' => 'Guru sudah memiliki jadwal pada jam tersebut.',
            ], 422);
        }

        $conflictKelas = JadwalPelajaran::where('hari', $hari)
            ->where('kelas_id', $kelasId)
            ->where(function ($query) use ($jamMulai, $jamSelesai) {
                $query->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                    ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai])
                    ->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                        $q->where('jam_mulai', '<=', $jamMulai)
                            ->where('jam_selesai', '>=', $jamSelesai);
                    });
            })->exists();

        if ($conflictKelas) {
            return response()->json([
                'message' => 'Kelas sudah memiliki jadwal lain pada jam tersebut.',
            ], 422);
        }

        $jadwal = JadwalPelajaran::create($request->all());

        return response()->json([
            'message' => 'Jadwal berhasil ditambahkan.',
            'data' => $jadwal,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalPelajaran::find($id);

        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal tidak ditemukan.'], 404);
        }

        $request->validate([
            'kelas_id' => 'sometimes|required|exists:ruang_kelas,id',
            'mapel_id' => 'sometimes|required|exists:mapels,id',
            'guru_id'  => 'sometimes|required|exists:gurus,id',
            'hari'     => 'sometimes|required|string|max:10',
            'jam_mulai' => 'sometimes|required|date_format:H:i',
            'jam_selesai' => 'sometimes|required|date_format:H:i|after:jam_mulai',
        ]);

        $jadwal->update($request->all());

        return response()->json([
            'message' => 'Jadwal berhasil diperbarui.',
            'data' => $jadwal,
        ]);
    }

    public function destroy($id)
    {
        $jadwal = JadwalPelajaran::find($id);

        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal tidak ditemukan.'], 404);
        }

        $jadwal->delete();

        return response()->json(['message' => 'Jadwal berhasil dihapus.']);
    }
}
