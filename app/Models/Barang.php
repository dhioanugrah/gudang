<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs'; // Pastikan ini sesuai dengan database
    protected $primaryKey = 'kode_barang'; // Menggunakan kode_barang sebagai primary key
    public $incrementing = false; // Nonaktifkan auto-increment
    protected $keyType = 'string'; // Primary key berupa string

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'merk',
        'ukuran',
        'part_number',
        'satuan',
        'stok'
    ];
}
