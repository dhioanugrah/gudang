<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiBarang extends Model
{
    use HasFactory;

    protected $table = 'mutasi_barang'; // Sesuaikan dengan nama tabel

    protected $fillable = [
        'barang_id',
        'tanggal',
        'jenis',
        'jumlah',
        'keterangan'
    ];

    // Relasi dengan model Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    // Event untuk update stok setelah penyimpanan mutasi barang
    protected static function booted()
    {
        // Event saat data mutasi barang baru dibuat
        static::created(function ($mutasiBarang) {
            $mutasiBarang->updateStokBarang();
        });

        // Event saat data mutasi barang diupdate
        static::updated(function ($mutasiBarang) {
            $mutasiBarang->updateStokBarang();
        });
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
