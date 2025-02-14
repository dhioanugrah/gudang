<?php
namespace App\Filament\Resources\PrResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;


class PrDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'prDetails';

    public function getTable(): Table // Hapus parameter $table
    {
        return Table::make() // Tambahkan ::make()
            ->columns([
                Tables\Columns\TextColumn::make('kode_barang')->label('Kode Barang')->sortable(),
                Tables\Columns\TextColumn::make('barang.nama')->label('Nama Barang')->sortable(),
                Tables\Columns\TextColumn::make('barang.merk')->label('Merk Barang')->sortable(),
                Tables\Columns\TextColumn::make('barang.ukuran')->label('Ukuran')->sortable(),
                Tables\Columns\TextColumn::make('barang.part_number')->label('Part Number')->sortable(),
                Tables\Columns\TextColumn::make('jumlah_diajukan')->label('Jumlah Diajukan')->sortable(),
            ]);
    }
}
