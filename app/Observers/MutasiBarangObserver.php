<?php

namespace App\Observers;

use App\Models\MutasiBarang;
use App\Models\Barang;

class MutasiBarangObserver
{
    public function created(MutasiBarang $mutasi)
    {
        if ($mutasi->jenis === 'output') {
            $barang = Barang::find($mutasi->barang_id);
            if ($barang) {
                $barang->decrement('stok', $mutasi->jumlah);
            }
        }
    }

    public function deleted(MutasiBarang $mutasi)
    {
        if ($mutasi->jenis === 'output') {
            $barang = Barang::find($mutasi->barang_id);
            if ($barang) {
                $barang->increment('stok', $mutasi->jumlah);
            }
        }
    }
}
