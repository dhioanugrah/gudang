<?php

namespace App\Http\Controllers;

use App\Models\MutasiBarang;
use App\Models\Barang;
use Illuminate\Http\Request;

class MutasiBarangKeluarController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi input hanya untuk barang keluar
            $request->validate([
                'barang_id' => 'required|exists:barangs,id',
                'tanggal' => 'required|date',
                'jumlah' => 'required|integer|min:1',
                'vendor' => 'required|string|max:255', // Validasi vendor
                'keterangan' => 'nullable|string',
            ]);

            // Ambil data barang
            $barang = Barang::findOrFail($request->barang_id);

            // Cek stok sebelum melakukan mutasi barang keluar
            if ($barang->stok < $request->jumlah) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk mutasi barang keluar!');
            }

            // Buat mutasi barang keluar
            $mutasiBarang = MutasiBarang::create([
                'barang_id' => $request->barang_id,
                'tanggal' => $request->tanggal,
                'jenis' => 'output', // Hanya barang keluar
                'jumlah' => $request->jumlah,
                'vendor' => $request->vendor, // Tambahkan vendor
                'keterangan' => $request->keterangan,
            ]);

            // Kurangi stok barang
            $barang->stok -= $request->jumlah;
            $barang->save();

            return redirect()->route('mutasi.index')->with('success', 'Mutasi barang keluar berhasil!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
