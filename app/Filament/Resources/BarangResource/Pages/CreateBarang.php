<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBarang extends CreateRecord
{
    protected static string $resource = BarangResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman utama barang setelah create
        return $this->getResource()::getUrl('index');
    }
}