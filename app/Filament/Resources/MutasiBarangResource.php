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
use Filament\Tables\Columns\BooleanColumn;

class MutasiBarangResource extends Resource
{
    protected static ?string $model = MutasiBarang::class;

    protected static ?string $navigationIcon = 'heroicon-s-currency-dollar';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('barang_id')
                    ->label('Barang')
                    ->options(Barang::all()->pluck('nama_barang', 'id'))
                    ->required(),
                Forms\Components\DatePicker::make('tanggal')
                    ->required(),
                Forms\Components\Select::make('jenis')
                    ->label('Jenis')
                    ->options([
                        'input' => 'Input',
                        'output' => 'Output',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->nullable(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('barang.nama_barang')->label('Nama Barang')->sortable()->searchable(),
                TextColumn::make('tanggal')->sortable(),
                TextColumn::make('jenis')->sortable(),
                TextColumn::make('jumlah')->sortable(),
                TextColumn::make('keterangan')->limit(50),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'edit' => Pages\EditMutasiBarang::route('/{record}/edit'),
        ];
    }
}
