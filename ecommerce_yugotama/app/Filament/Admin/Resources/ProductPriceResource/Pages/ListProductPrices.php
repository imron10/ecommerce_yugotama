<?php

namespace App\Filament\Admin\Resources\ProductPriceResource\Pages;

use App\Filament\Admin\Resources\ProductPriceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductPrices extends ListRecords
{
    protected static string $resource = ProductPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Harga'),
        ];
    }
}
