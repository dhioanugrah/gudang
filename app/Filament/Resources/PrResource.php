<?php

    namespace App\Filament\Resources;

    use App\Filament\Resources\PrResource\Pages;
    use App\Models\Pr;
    use Filament\Forms;
    use Filament\Forms\Form;
    use Filament\Resources\Resource;
    use Filament\Tables;
    use Filament\Forms\Components\Section;
    use Filament\Forms\Components\Grid;
    use Filament\Forms\Components\TextEntry;
    use Filament\Forms\Components\Group;
    use App\Filament\Resources\PrResource\RelationManagers\PrDetailsRelationManager;

    use Filament\Tables\Table;

    class PrResource extends Resource
    {

        protected static ?string $navigationIcon = 'heroicon-s-archive-box';
        protected static ?string $pluralLabel = 'Process Request'; // Nama di sidebar dan halaman
        protected static ?string $navigationLabel = 'Process Request'; // Nama di sidebar

        protected static ?string $model = Pr::class;

        public static function relationManagers(): array
        {
            return [
                PrDetailsRelationManager::class,
            ];
        }

        public static function form(Form $form): Form
        {
            return $form->schema([
                Forms\Components\TextInput::make('no_pr')
                ->label('No PR')
                ->disabled() // Supaya user tidak bisa edit/input
                ->dehydrated(false) // Supaya tidak dikirim ke backend saat submit
                ->default(fn () => \App\Models\Pr::generateNoPr()), // Generate otomatis
                Forms\Components\DatePicker::make('tanggal_diajukan')
                    ->required(),
                Forms\Components\TextInput::make('required_for')
                    ->required(),
                Forms\Components\TextInput::make('request_by')
                    ->required(),
            ]);
        }

        public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    Tables\Columns\TextColumn::make('no_pr')->sortable()->searchable(),
                    Tables\Columns\TextColumn::make('tanggal_diajukan')->sortable(),
                    Tables\Columns\TextColumn::make('required_for')->sortable(),
                    Tables\Columns\TextColumn::make('request_by')->sortable(),
                ])
                ->actions([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),

                    Tables\Actions\Action::make('Tambah Barang')
                    ->icon('heroicon-o-plus-circle')
                    ->modalHeading('Tambah Barang ke PR')
                    ->modalButton('Simpan')
                    ->modalWidth('md')
                    ->action(function ($record, $data) {
                        \App\Models\PrDetail::create([
                            'pr_id' => $record->id,
                            'kode_barang' => $data['kode_barang'],
                            'jumlah_diajukan' => $data['jumlah_diajukan'],
                        ]);

                        // ✅ Notifikasi sukses!
                        \Filament\Notifications\Notification::make()
                            ->title('Barang berhasil ditambahkan!')
                            ->success()
                            ->send();
                    })
                    ->form([
                        Forms\Components\Select::make('kode_barang')
                            ->label('Kode Barang')
                            ->options(\App\Models\Barang::all()->pluck('kode_barang', 'kode_barang'))
                            ->required(),
                        Forms\Components\TextInput::make('jumlah_diajukan')
                            ->label('Jumlah Diajukan')
                            ->numeric()
                            ->required(),
                    ]),



                    Tables\Actions\Action::make('detail')
                        ->icon('heroicon-o-eye')
                        ->modalHeading('Detail Barang PR')
                        ->modalButton('Tutup')
                        ->modalWidth('2xl')
                        ->modalContent(fn ($record) => view('filament.tables.detail-pr', ['prDetails' => $record->prDetails])
                ),

                Tables\Actions\Action::make('Cek Pengajuan')
                ->icon('heroicon-o-eye')
                ->button()
                ->color('primary')
                ->url(fn ($record) => PrResource::getUrl('cek-pengajuan', ['record' => $record->id]))




                ]);
        }

        public static function getPages(): array
        {
            return [
                'index' => Pages\ListPrs::route('/'),
                'create' => Pages\CreatePr::route('/create'),
                'edit' => Pages\EditPr::route('/{record}/edit'),
                'cek-pengajuan' => Pages\CekPengajuan::route('/{record}/cek-pengajuan'),

            ];
        }

    }
