<?php

namespace App\Filament\Resources\PrDetailResource\Pages;

use App\Filament\Resources\PrDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrDetail extends EditRecord
{
    protected static string $resource = PrDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
