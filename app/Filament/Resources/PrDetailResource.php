<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrDetailResource\Pages;
use App\Models\PrDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PrDetailResource extends Resource
{
    protected static ?string $model = PrDetail::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('pr_id')
                ->relationship('pr', 'no_pr')
                ->required(),
            Forms\Components\TextInput::make('kode_barang')
                ->required(),
            Forms\Components\TextInput::make('nama_barang')
                ->required(),
            Forms\Components\TextInput::make('jumlah')
                ->numeric()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pr.no_pr')->label('Nomor PR')->sortable(),
                Tables\Columns\TextColumn::make('kode_barang')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('barang.nama_barang')->sortable(),
                Tables\Columns\TextColumn::make('jumlah_diajukan')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('pr_id')
                    ->relationship('pr', 'no_pr')
                    ->label('Filter Berdasarkan PR'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrDetails::route('/'),
            'create' => Pages\CreatePrDetail::route('/create'),
            'edit' => Pages\EditPrDetail::route('/{record}/edit'),
        ];
    }
}
