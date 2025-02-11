<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get-barang/{kode_barang}', function ($kode_barang) {
    $barang = Barang::where('kode_barang', $kode_barang)->first();
    return response()->json($barang);
});