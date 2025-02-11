<?php

namespace App\Filament\Resources\PrResource\Pages;

use App\Filament\Resources\PrResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrs extends ListRecords
{
    protected static string $resource = PrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
