<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-s-archive-box';


    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_barang')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('nama_barang')
                    ->required(),
                Forms\Components\TextInput::make('merk')
                    ->required(),
                Forms\Components\TextInput::make('ukuran')
                    ->required(),
                Forms\Components\TextInput::make('part_number')
                    ->required(),
                Forms\Components\TextInput::make('satuan')
                    ->required(),
                Forms\Components\TextInput::make('stok')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_barang')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nama_barang')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('merk')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('ukuran')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('part_number')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('satuan'),
                Tables\Columns\TextColumn::make('stok')->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
