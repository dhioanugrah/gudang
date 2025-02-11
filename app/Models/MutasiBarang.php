<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MutasiBarang extends Model
{
    use HasFactory;

    protected $table = 'mutasi_barang'; // Sesuaikan dengan nama tabel

    protected $fillable = [
        'barang_id',
        'tanggal',
        'jenis',
        'jumlah',
        'keterangan',
        'pengguna', // Tambahkan pengguna
    ];



    // Relasi dengan model Barang
    public function barangs(): BelongsTo
    {
        return $this->belongsTo(barangs::class);
    }

    // Event untuk update stok setelah penyimpanan mutasi barang
    protected static function booted()
    {
        static::creating(function ($mutasiBarang) {
            $mutasiBarang->cekStokSebelumMutasi();
        });

        static::created(function ($mutasiBarang) {
            $mutasiBarang->updateStokBarang();
        });

        static::updated(function ($mutasiBarang) {
            $mutasiBarang->updateStokBarang();
        });
    }

    // Cek stok sebelum mutasi untuk mencegah stok negatif
    public function cekStokSebelumMutasi()
    {
        $barang = $this->barang;

        // Jangan lempar exception, cukup return false
        if ($this->jenis === 'output' && $this->jumlah > $barang->stok) {
            return false;
        }

        return true;
    }


    // Update stok setelah mutasi
    public function updateStokBarang()
    {
        $barang = $this->barang;

        if ($this->jenis === 'input') {
            $barang->stok += $this->jumlah;
        } elseif ($this->jenis === 'output') {
            $barang->stok -= $this->jumlah;
        }

        $barang->save();
    }
}
