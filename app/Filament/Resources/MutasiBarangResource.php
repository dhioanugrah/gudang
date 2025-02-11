<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MutasiBarangResource\Pages;
use App\Models\MutasiBarang;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class MutasiBarangResource extends Resource
{
    protected static ?string $model = MutasiBarang::class;

    protected static ?string $navigationIcon = 'heroicon-s-currency-dollar';

    protected static ?string $pluralLabel = 'Mutasi Barang Keluar';
    protected static ?string $navigationLabel = 'Barang Keluar';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('barang_id')
                ->label('Kode Barang') // Mengubah label menjadi Kode Barang
                ->searchable() // Menjadikan select bisa dicari
                ->options(fn () => Barang::pluck('kode_barang', 'kode_barang'))
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {

                    \Log::info('Barang yang dipilih: ', ['id' => $state, 'barang' => Barang::find((int) $state)]);
                    \Log::info('Barang yang dipilih: ', ['kode_barang' => $state, 'barang' => Barang::find($state)]);


                    if (!$state) {
                        $set('barang_info', "- | - | -");
                        $set('max_stok', 0);
                        return;
                    }

                    // Ambil data barang dari database
                    $barang = Barang::find($state);


                    if (!$barang) {
                        $set('barang_info', "- | - | -");
                        $set('max_stok', 0);
                        return;
                    }

                    // Pastikan nilai tidak kosong, jika kosong ganti dengan "-"
                    $merk = $barang->merk ?: '-';
                    $ukuran = $barang->ukuran ?: '-';
                    $part_number = $barang->part_number ?: '-';

                    // Set informasi barang
                    $set('barang_info', "{$merk} | {$ukuran} | {$part_number}");
                    $set('max_stok', $barang->stok ?? 0);
                }),

            Forms\Components\TextInput::make('barang_info')
                ->label('Merk | Ukuran | Part Number')
                ->disabled()
                ->live(), // Pastikan nilai selalu diperbarui


            Forms\Components\Hidden::make('max_stok'), // Menyimpan stok barang saat ini

            Forms\Components\DatePicker::make('tanggal')
                ->required(),

            Forms\Components\TextInput::make('jumlah')
                ->label('Jumlah')
                ->required()
                ->numeric()
                ->minValue(1)
                ->step(1)
                ->rule(function (callable $get) {
                    $stok = $get('max_stok') ?? 0;
                    return "max:$stok"; // Membatasi jumlah barang keluar sesuai stok
                }, 'Jumlah keluar tidak boleh lebih dari stok tersedia'),

            Forms\Components\TextInput::make('pengguna')
                ->label('Pengguna')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('keterangan')
                ->label('Keterangan')
                ->nullable(),

            Forms\Components\Hidden::make('jenis')->default('output'), // Hanya Barang Keluar
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('barang.nama_barang')->label('Nama Barang')->sortable()->searchable(),
                TextColumn::make('barang.merk')->label('Merk')->sortable()->searchable(),
                TextColumn::make('barang.ukuran')->label('Ukuran')->sortable()->searchable(),
                TextColumn::make('barang.part_number')->label('Part Number')->sortable()->searchable(),
                TextColumn::make('tanggal')->sortable(),
                TextColumn::make('jumlah')->sortable(),
                TextColumn::make('pengguna')->label('Pengguna')->sortable()->searchable(),
                TextColumn::make('keterangan')->limit(50),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMutasiBarangs::route('/'),
            'create' => Pages\CreateMutasiBarang::route('/create'),
        ];
    }
}
