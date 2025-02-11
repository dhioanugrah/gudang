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

    protected static ?string $pluralLabel = 'Mutasi Barang Keluar'; // Nama di sidebar dan halaman
    protected static ?string $navigationLabel = 'Barang Keluar'; // Nama di sidebar

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('barang_id')
                    ->label('Nama Barang')
                    ->options(Barang::all()->pluck('nama_barang', 'id'))
                    ->required()
                    ->reactive() // Agar stok bisa dicek langsung
                    ->afterStateUpdated(fn ($state, callable $set) =>
                        $set('max_stok', Barang::find($state)?->stok ?? 0)
                    ),
                Forms\Components\Hidden::make('max_stok'), // Menyimpan stok barang saat ini

                Forms\Components\DatePicker::make('tanggal')
                    ->required(),

                Forms\Components\TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->required()
                    ->numeric()
                    ->minValue(1) // Tidak bisa kurang dari 1
                    ->step(1) // Hanya angka bulat
                    ->rule(function (callable $get) {
                        $stok = $get('max_stok') ?? 0;
                        return "max:$stok"; // Membatasi jumlah barang yang bisa keluar sesuai stok
                    }, 'Jumlah keluar tidak boleh lebih dari stok tersedia'),

                // Forms\Components\TextInput::make('vendor')
                //     ->label('Vendor')
                //     ->required()
                //     ->maxLength(255),

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
                TextColumn::make('tanggal')->sortable(),
                TextColumn::make('jumlah')->sortable(),
                // TextColumn::make('vendor')->label('Vendor')->sortable()->searchable(),
                TextColumn::make('keterangan')->limit(50),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(), // Hanya bisa hapus, tidak bisa edit
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
