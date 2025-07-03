<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransaksiDaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class TransaksiDaftarController extends Controller
{
    public function index()
    {
        return response()->json(TransaksiDaftar::with('user')->get());
    }

    public function show($id)
    {
        $transaksi = TransaksiDaftar::with('user')->find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        return response()->json($transaksi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'metode' => 'required|string',
            'status' => 'required|in:pending,sukses,gagal',
            'jumlah' => 'required|numeric',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->only(['user_id', 'metode', 'status', 'jumlah']);

        // Jika ada upload file bukti
        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('bukti-transaksi', 'public');
        }

        $transaksi = TransaksiDaftar::create($data);

        return response()->json([
            'message' => 'Transaksi berhasil ditambahkan.',
            'data' => $transaksi,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $transaksi = TransaksiDaftar::find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $request->validate([
            'metode' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:pending,sukses,gagal',
            'jumlah' => 'sometimes|required|numeric',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->only(['metode', 'status', 'jumlah']);

        // Jika upload bukti baru
        if ($request->hasFile('bukti')) {
            // Hapus bukti lama (jika ada)
            if ($transaksi->bukti && Storage::disk('public')->exists($transaksi->bukti)) {
                Storage::disk('public')->delete($transaksi->bukti);
            }
            $data['bukti'] = $request->file('bukti')->store('bukti-transaksi', 'public');
        }

        $transaksi->update($data);

        return response()->json([
            'message' => 'Transaksi berhasil diperbarui.',
            'data' => $transaksi,
        ]);
    }

    public function destroy($id)
    {
        $transaksi = TransaksiDaftar::find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        // Hapus bukti jika ada
        if ($transaksi->bukti && Storage::disk('public')->exists($transaksi->bukti)) {
            Storage::disk('public')->delete($transaksi->bukti);
        }

        $transaksi->delete();

        return response()->json(['message' => 'Transaksi berhasil dihapus.']);
    }
}
