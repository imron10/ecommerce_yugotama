<?php

namespace App\Filament\Admin\Resources\ProductPrices\Pages;

use App\Filament\Admin\Resources\ProductPrices\ProductPriceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageProductPrices extends ManageRecords
{
    protected static string $resource = ProductPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
