<?php

namespace App\Http\Controllers;

use App\Models\MutasiBarang;
use App\Models\Barang;
use Illuminate\Http\Request;

class MutasiBarangController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'barang_id' => 'required|exists:barangs,id',
                'tanggal' => 'required|date',
                'jenis' => 'required|in:input,output',
                'jumlah' => 'required|integer|min:1',
                'keterangan' => 'nullable|string',
            ]);

            // Ambil data barang
            $barang = Barang::findOrFail($request->barang_id);

            // **Cek stok sebelum melakukan mutasi (khusus output)**
            if ($request->jenis === 'output' && $barang->stok < $request->jumlah) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk mutasi output!');
            }

            // Buat mutasi barang
            $mutasiBarang = MutasiBarang::create($request->all());

            // Update stok barang setelah mutasi berhasil dibuat
            if ($request->jenis === 'input') {
                $barang->stok += $request->jumlah;
            } else {
                $barang->stok -= $request->jumlah;
            }
            $barang->save();

            return redirect()->route('mutasi.index')->with('success', 'Mutasi barang berhasil!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
