<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalonSiswa;

class CalonSiswaController extends Controller
{
    public function index()
    {
        $calonSiswas = CalonSiswa::all();
        return response()->json($calonSiswas);
    }

    public function show($id)
    {
        $calonSiswa = CalonSiswa::find($id);

        if (!$calonSiswa) {
            return response()->json(['message' => 'Calon siswa tidak ditemukan.'], 404);
        }

        return response()->json($calonSiswa);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'     => 'required|string|max:255',
            'jenis_kelamin'    => 'required|in:Laki-Laki,Perempuan',
            'tempat_lahir'     => 'required|string|max:255',
            'tanggal_lahir'    => 'required|date',
            'asal_tk'          => 'required|string',
            'alamat'           => 'required|string',
            'nama_ortu'        => 'required|string|max:255',
            'email_ortu'       => 'required|email|max:255',
            'no_handphone'     => 'required|string|max:20',
            'kartu_keluarga'   => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akta_lahir'       => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'pas_foto'         => 'required|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        // Proses Upload File
        $kkPath = $request->file('kartu_keluarga')->store('dokumen/kk', 'public');
        $aktaPath = $request->file('akta_lahir')->store('dokumen/akta', 'public');
        $fotoPath = $request->file('pas_foto')->store('dokumen/foto', 'public');

        // Simpan ke Database
        $calonSiswa = CalonSiswa::create([
            'nama_lengkap'     => $request->nama_lengkap,
            'jenis_kelamin'    => $request->jenis_kelamin,
            'tempat_lahir'     => $request->tempat_lahir,
            'tanggal_lahir'    => $request->tanggal_lahir,
            'asal_tk'          => $request->asal_tk,
            'alamat'           => $request->alamat,
            'nama_ortu'        => $request->nama_ortu,
            'email_ortu'       => $request->email_ortu,
            'no_handphone'     => $request->no_handphone,
            'kartu_keluarga'   => $kkPath,
            'akta_lahir'       => $aktaPath,
            'pas_foto'         => $fotoPath,
        ]);

        return response()->json([
            'message' => 'Calon siswa berhasil ditambahkan.',
            'calon_siswa' => $calonSiswa
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $calonSiswa = CalonSiswa::find($id);

        if (!$calonSiswa) {
            return response()->json(['message' => 'Calon siswa tidak ditemukan.'], 404);
        }

        $request->validate([
            'nama_lengkap'  => 'sometimes|required|string|max:255',
            'nis'           => 'sometimes|required|string|unique:calon_siswas,nis,' . $calonSiswa->id,
            'jenis_kelamin' => 'sometimes|required|in:Laki-Laki,Perempuan',
            'agama'         => 'sometimes|required|string|max:50',
            'tempat_lahir'  => 'sometimes|required|string|max:255',
            'tanggal_lahir' => 'sometimes|required|date',
            'alamat'        => 'sometimes|required|string',
            'nama_ayah'     => 'sometimes|required|string|max:255',
            'nama_ibu'      => 'sometimes|required|string|max:255',
            'no_handphone'  => 'sometimes|required|string|max:20',
            'user_id'       => 'nullable|exists:users,id',
        ]);

        $calonSiswa->update($request->all());

        return response()->json([
            'message' => 'Calon siswa berhasil diupdate.',
            'calon_siswa' => $calonSiswa
        ]);
    }

    public function destroy($id)
    {
        $calonSiswa = CalonSiswa::find($id);

        if (!$calonSiswa) {
            return response()->json(['message' => 'Calon siswa tidak ditemukan.'], 404);
        }

        $calonSiswa->delete();

        return response()->json(['message' => 'Calon siswa berhasil dihapus.']);
    }
}
