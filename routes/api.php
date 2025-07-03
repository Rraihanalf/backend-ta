<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\CalonSiswaController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\GuruPengampuController;
use App\Http\Controllers\Api\JadwalPelajaranController;
use App\Http\Controllers\Api\MapelController;
use App\Http\Controllers\Api\NilaiSiswaController;
use App\Http\Controllers\Api\RuangKelasController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\TransaksiDaftarController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function(){
    return "Coba";
});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/calon-siswas', [CalonSiswaController::class, 'store']);

Route::middleware('auth:sanctum')->get('/cek-user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/cek-gate', function (Request $request) {
    if (Gate::allows('admin')) {
        return 'ADMIN BOLEH MASUK';
    }

    return response('FORBIDDEN', 403);
});

Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
    Route::get('/admin-only', function () {
        return 'Hanya Admin!';
    });

    Route::get('/admin/profile', function (Request $request) {
        return response()->json([
        'id' => $request->user()->id,
        'name' => $request->user()->name,
        'email' => $request->user()->email,
        'role' => $request->user()->role
        ]);
    });

    Route::get('/admin/users', [UserController::class, 'index']);    
    Route::get('/admin/users/{id}', [UserController::class, 'show']); 
    Route::post('/admin/users', [UserController::class, 'store']);    
    Route::put('/admin/users/{id}', [UserController::class, 'update']); 
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy']); 

    Route::get('/admin/calon-siswas', [CalonSiswaController::class, 'index']);    
    Route::get('/admin/calon-siswas/{id}', [CalonSiswaController::class, 'show']); 
    Route::put('/admin/calon-siswas/{id}', [CalonSiswaController::class, 'update']); 
    Route::delete('/admin/calon-siswas/{id}', [CalonSiswaController::class, 'destroy']);

    Route::get('/admin/gurus', [GuruController::class, 'index']);
    Route::get('/admin/gurus/{id}', [GuruController::class, 'show']); 
    Route::post('/admin/gurus', [GuruController::class, 'store']);    
    Route::put('/admin/gurus/{id}', [GuruController::class, 'update']); 
    Route::delete('/admin/gurus/{id}', [GuruController::class, 'destroy']);

    Route::get('/admin/siswas', [SiswaController::class, 'index']);
    Route::get('/admin/siswas', [SiswaController::class, 'byJadwal']);
    Route::get('/admin/siswas/{id}', [SiswaController::class, 'show']);
    Route::post('/admin/siswas', [SiswaController::class, 'store']);
    Route::put('/admin/siswas/{id}', [SiswaController::class, 'update']);
    Route::delete('/admin/siswas/{id}', [SiswaController::class, 'destroy']);

    Route::get('/admin/ruang-kelas', [RuangKelasController::class, 'index']);
    Route::get('/admin/ruang-kelas/{id}', [RuangKelasController::class, 'show']);
    Route::post('/admin/ruang-kelas', [RuangKelasController::class, 'store']);
    Route::put('/admin/ruang-kelas/{id}', [RuangKelasController::class, 'update']);
    Route::delete('/admin/ruang-kelas/{id}', [RuangKelasController::class, 'destroy']);

    Route::get('/admin/mapel', [MapelController::class, 'index']);
    Route::get('/admin/mapel/{id}', [MapelController::class, 'show']);
    Route::post('/admin/mapel', [MapelController::class, 'store']);
    Route::put('/admin/mapel/{id}', [MapelController::class, 'update']);
    Route::delete('/admin/mapel/{id}', [MapelController::class, 'destroy']);

    Route::get('/admin/guru-pengampu', [GuruPengampuController::class, 'index']);
    Route::get('/admin/guru-pengampu', [GuruPengampuController::class, 'byMapel']);
    Route::get('/admin/guru-pengampu/{id}', [GuruPengampuController::class, 'show']);
    Route::post('/admin/guru-pengampu', [GuruPengampuController::class, 'store']);
    Route::put('/admin/guru-pengampu/{id}', [GuruPengampuController::class, 'update']);
    Route::delete('/admin/guru-pengampu/{id}', [GuruPengampuController::class, 'destroy']);

    Route::get('/admin/jadwal', [JadwalPelajaranController::class, 'index']);
    Route::get('/admin/jadwal/{id}', [JadwalPelajaranController::class, 'show']);
    Route::post('/admin/jadwal', [JadwalPelajaranController::class, 'store']);
    Route::put('/admin/jadwal/{id}', [JadwalPelajaranController::class, 'update']);
    Route::delete('/admin/jadwal/{id}', [JadwalPelajaranController::class, 'destroy']);

    Route::get('/admin/nilai', [NilaiSiswaController::class, 'index']);
    Route::get('/admin/nilai/{id}', [NilaiSiswaController::class, 'show']);
    Route::post('/admin/nilai', [NilaiSiswaController::class, 'store']);
    Route::put('/admin/nilai/{id}', [NilaiSiswaController::class, 'update']);
    Route::delete('/admin/nilai/{id}', [NilaiSiswaController::class, 'destroy']);

    Route::get('/admin/absensi', [AbsensiController::class, 'index']);
    Route::get('/admin/absensi/{id}', [AbsensiController::class, 'show']);
    Route::post('/admin/absensi', [AbsensiController::class, 'store']);
    Route::put('/admin/absensi/{id}', [AbsensiController::class, 'update']);
    Route::delete('/admin/absensi/{id}', [AbsensiController::class, 'destroy']);

    Route::get('/admin/transaksi', [TransaksiDaftarController::class, 'index']);
    Route::get('/admin/transaksi/{id}', [TransaksiDaftarController::class, 'show']);
    Route::post('/admin/transaksi', [TransaksiDaftarController::class, 'store']);
    Route::put('/admin/transaksi/{id}', [TransaksiDaftarController::class, 'update']);
    Route::delete('/admin/transaksi/{id}', [TransaksiDaftarController::class, 'destroy']);

    Route::get('/admin/spp-siswa', [TransaksiDaftarController::class, 'index']);
    Route::get('/admin/spp-siswa/{id}', [TransaksiDaftarController::class, 'show']);
    Route::post('/admin/spp-siswa', [TransaksiDaftarController::class, 'store']);
    Route::put('/admin/spp-siswa/{id}', [TransaksiDaftarController::class, 'update']);
    Route::delete('/admin/spp-siswa/{id}', [TransaksiDaftarController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'can:guru'])->group(function () {
    Route::get('/guru-only', function () {
        return 'Hanya Guru!';
    });

    Route::get('/admin/profile', function (Request $request) {
        return response()->json([
        'id' => $request->user()->id,
        'name' => $request->user()->name,
        'email' => $request->user()->email,
        'role' => $request->user()->role
        ]);
    });

    Route::get('/gurus/{id}', [GuruController::class, 'show']);
    Route::put('/gurus/{id}', [GuruController::class, 'update']);

    Route::get('/guru/siswas', [SiswaController::class, 'index']);
    // Route::get('/guru/siswas', [SiswaController::class, 'getSiswaByGuru']);
    Route::get('/guru/siswas/{id}', [SiswaController::class, 'show']);

    Route::get('/guru/ruang-kelas/{id}', [RuangKelasController::class, 'show']);

    Route::get('/guru/mapel', [MapelController::class, 'index']);

    Route::get('/guru/jadwal', [JadwalPelajaranController::class, 'index']);
    Route::get('/guru/jadwal/{id}', [JadwalPelajaranController::class, 'show']);

    Route::get('/guru/absensi', [AbsensiController::class, 'index']);
    Route::get('/guru/absensi/{id}', [AbsensiController::class, 'show']);
    Route::post('/guru/absensi', [AbsensiController::class, 'store']);
    Route::put('/guru/absensi/{id}', [AbsensiController::class, 'update']);
    Route::delete('/guru/absensi/{id}', [AbsensiController::class, 'destroy']);

    Route::get('/guru/nilai', [NilaiSiswaController::class, 'index']);
    Route::get('/guru/nilai/{id}', [NilaiSiswaController::class, 'show']);
    Route::post('/guru/nilai', [NilaiSiswaController::class, 'store']);
    Route::put('/guru/nilai/{id}', [NilaiSiswaController::class, 'update']);
    Route::delete('/guru/nilai/{id}', [NilaiSiswaController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'can:wali'])->group(function () {
    Route::get('/wali-only', function () {
        return 'Hanya Wali!';
    });

    Route::post('/wali/calon-siswas', [CalonSiswaController::class, 'store']);
    Route::get('/ruang-kelas/{id}', [RuangKelasController::class, 'show']);

    Route::put('/wali/siswas/{id}', [SiswaController::class, 'update']);

    Route::get('/wali/transaksi/{id}', [TransaksiDaftarController::class, 'show']);
    Route::post('/wali/transaksi', [TransaksiDaftarController::class, 'store']);
    Route::put('/wali/transaksi/{id}', [TransaksiDaftarController::class, 'update']);
    Route::delete('/wali/transaksi/{id}', [TransaksiDaftarController::class, 'destroy']);
});