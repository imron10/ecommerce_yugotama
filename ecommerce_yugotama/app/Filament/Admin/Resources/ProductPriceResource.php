<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductPriceResource\Pages;
use App\Models\Branch;
use App\Models\ProductPrice;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductPriceResource extends Resource
{
    protected static ?string $model = ProductPrice::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-currency-dollar';
    }
    protected static ?string $navigationLabel = 'Harga per Cabang (ditiadakan)';
    protected static ?string $pluralModelLabel = 'Harga per Cabang';
    protected static ?string $modelLabel = 'Harga Cabang';
    protected static ?int $navigationSort = 99;

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Disembunyikan karena sistem 1 toko — harga langsung di produk
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Section::make('Pilih Produk')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Produk')
                            ->relationship('product', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(),
                    ]),

                Schemas\Components\Section::make('Harga per Cabang')
                    ->description('Semua cabang ditampilkan dalam 1 layar. Isi harga untuk tiap cabang.')
                    ->schema([
                        Forms\Components\Repeater::make('branches')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('branch_id')
                                    ->label('Cabang')
                                    ->relationship('branch', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->disabled()
                                    ->columnSpan(4),
                                Forms\Components\TextInput::make('price')
                                    ->label('Harga')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0)
                                    ->maxValue(999999999)
                                    ->columnSpan(4),
                            ])
                            ->columns(8)
                            ->columnSpanFull()
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->defaultItems(function () {
                                return Branch::where('is_active', true)
                                    ->get()
                                    ->map(fn($branch) => [
                                        'branch_id' => $branch->id,
                                        'price' => 0,
                                    ])
                                    ->toArray();
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('product.sku')
                    ->label('SKU')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('branch.name')
                    ->label('Cabang')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('branch')
                    ->label('Cabang')
                    ->relationship('branch', 'name'),
                Tables\Filters\SelectFilter::make('product')
                    ->label('Produk')
                    ->relationship('product', 'name')
                    ->searchable(),
            ])
            ->actions([
                Actions\EditAction::make()->label('Edit'),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['product', 'branch']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductPrices::route('/'),
            'create' => Pages\CreateProductPrice::route('/create'),
            'edit' => Pages\EditProductPrice::route('/{record}/edit'),
        ];
    }
}
