<?php

namespace App\Http\Controllers;

use App\Models\MutasiBarang;
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

            // Proses untuk menyimpan mutasi barang
            $mutasiBarang = MutasiBarang::create([
                'barang_id' => $request->barang_id,
                'tanggal' => $request->tanggal,
                'jenis' => $request->jenis,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
            ]);

            // Jika berhasil, kirim response sukses
            return redirect()->route('mutasi.index')->with('success', 'Mutasi barang berhasil');
        } catch (\Exception $e) {
            // Tangkap exception jika stok tidak cukup
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


        public function updateStokBarang()
    {
        $barang = $this->barang;

        // Jika jenis mutasi adalah input, tambahkan stok
        if ($this->jenis == 'input') {
            $barang->stok += $this->jumlah;
        }
        // Jika jenis mutasi adalah output
        elseif ($this->jenis == 'output') {
            // Cek apakah jumlah yang dimutasi lebih banyak dari stok
            if ($this->jumlah > $barang->stok) {
                // Jika jumlah mutasi lebih besar dari stok, batalkan mutasi dan beri error
                throw new \Exception('Stok tidak cukup untuk mutasi output');
            }

            // Kurangi stok jika jumlahnya valid
            $barang->stok -= $this->jumlah;
        }

        // Simpan perubahan stok
        $barang->save();
    }

}
