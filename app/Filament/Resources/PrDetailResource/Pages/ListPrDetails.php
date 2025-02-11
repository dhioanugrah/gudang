<?php

namespace App\Filament\Resources\PrDetailResource\Pages;

use App\Filament\Resources\PrDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrDetails extends ListRecords
{
    protected static string $resource = PrDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
