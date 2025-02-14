<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mutasi_barang', function (Blueprint $table) {
            $table->id(); // Primary key (Auto Increment)
            $table->string('kode_barang'); // Kode barang sebagai string
            $table->date('tanggal'); // Tanggal mutasi
            $table->integer('jumlah'); // Jumlah barang
            $table->string('pengguna'); // Nama pengguna yang melakukan mutasi
            $table->text('keterangan')->nullable(); // Catatan tambahan (opsional)
            $table->enum('jenis', ['input', 'output']); // Jenis mutasi (masuk/keluar)
            $table->timestamps(); // Kolom created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_barang');
    }
};