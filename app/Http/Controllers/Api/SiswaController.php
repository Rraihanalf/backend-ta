<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\RuangKelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::with('kelas')->get();
        return response()->json($siswas);
    }

    public function show($id)
    {
        $siswa = Siswa::with('kelas')->find($id);

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
        }

        return response()->json($siswa);
    }

    public function byJadwal(Request $request)
    {
        $jadwalId = $request->query('jadwal_id');

        $jadwal = JadwalPelajaran::findOrFail($jadwalId);
    
        $siswa = Siswa::where('kelas_id', $jadwal->kelas_id)->get();

        return response()->json($siswa);
    }

    public function store(Request $request)
    {
        try{

            $request->validate([
                'nama_lengkap'   => 'required|string|max:255',
                'nis'            => 'required|string|unique:siswas,nis|max:10',
                'jenis_kelamin'  => 'required|in:Laki-Laki,Perempuan',
                'agama'          => 'required|string|max:50',
                'tempat_lahir'   => 'required|string|max:255',
                'tanggal_lahir'  => 'required|date',
                'alamat'         => 'required|string',
                'nama_ayah'      => 'required|string|max:255',
                'nama_ibu'       => 'required|string|max:255',
            ]);

            $siswa = Siswa::create($request->all());

            return response()->json([
                'message' => 'Siswa berhasil ditambahkan.',
                'siswa' => $siswa
            ], 201);
        }catch (\Exception $e) {
                return response()->json([
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
        }

        $request->validate([
            'nama_lengkap'   => 'sometimes|max:255',
            'nis'            => 'sometimes|unique:siswas,nis,' . $siswa->id,
            'jenis_kelamin'  => 'sometimes:Laki-Laki,Perempuan',
            'agama'          => 'sometimes',
            'tempat_lahir'   => 'sometimes|max:255',
            'tanggal_lahir'  => 'sometimes',
            'alamat'         => 'sometimes',
            'nama_ayah'      => 'sometimes|max:255',
            'nama_ibu'       => 'sometimes|max:255',
            'rt'             => 'sometimes|max:5',
            'rw'             => 'sometimes|max:5',
            'kelurahan'      => 'sometimes|max:100',
            'kecamatan'      => 'sometimes|max:100',
            'kota'           => 'sometimes|max:100',
            'provinsi'       => 'sometimes|max:100',
            'kode_pos'       => 'sometimes|max:10',
            'no_handphone'   => 'sometimes|max:20',
            'user_id'        => 'nullable|exists:users,id',
            'kelas_id'        => 'nullable|exists:ruang_kelas,id',
        ]);

        $siswa->update($request->all());

        return response()->json([
            'message' => 'Siswa berhasil diperbarui.',
            'siswa' => $siswa
        ]);
    }

    public function destroy($id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
        }

        $siswa->delete();

        return response()->json(['message' => 'Siswa berhasil dihapus.']);
    }

    public function getSiswaByGuru(Request $request)
    {
        $guru = auth('guru')->user(); 
        if (!$guru) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Ambil ID semua kelas milik guru ini
        $kelasIds = RuangKelas::where('guru_id', $guru->id)->pluck('id');

        // Ambil semua siswa dari kelas tersebut
        $siswas = Siswa::whereIn('kelas_id', $kelasIds)
                    ->with('kelas') // agar bisa akses nama kelas di frontend
                    ->get();

        return response()->json($siswas);
    }
}
