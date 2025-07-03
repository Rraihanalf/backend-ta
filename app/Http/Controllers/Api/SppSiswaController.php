<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SppSiswa;
use Illuminate\Http\Request;

class SppSiswaController extends Controller
{
    public function index()
    {
        return response()->json(SppSiswa::with('siswa')->get());
    }

    public function show($id)
    {
        $transaksi = SppSiswa::with('siswa')->find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Data SPP tidak ditemukan'], 404);
        }

        return response()->json($transaksi);
    }

    public function store(Request $request){

    }

    public function update(Request $request, $id){
        
    }

    public function destroy($id){
        
    }
}
