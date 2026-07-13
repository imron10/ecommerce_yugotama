<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PromoResource\Pages;
use App\Models\Promo;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PromoResource extends Resource
{
    protected static ?string $model = Promo::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-megaphone';
    }
    protected static ?string $navigationLabel = 'Promo';
    protected static ?string $pluralModelLabel = 'Promo';
    protected static ?string $modelLabel = 'Promo';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Section::make('Informasi Promo')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Promo')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])->columns(2),

                Schemas\Components\Section::make('Pengaturan Diskon')
                    ->schema([
                        Forms\Components\Select::make('discount_type')
                            ->label('Tipe Diskon')
                            ->options([
                                'percentage' => 'Persentase (%)',
                                'nominal' => 'Nominal (Rp)',
                                'fixed_price' => 'Harga Tetap',
                            ])
                            ->required()
                            ->live()
                            ->helperText('Persentase: potong % dari harga. Nominal: potong Rp. Harga Tetap: set harga langsung.'),
                        Forms\Components\TextInput::make('discount_value')
                            ->label('Nilai Diskon')
                            ->required()
                            ->numeric()
                            ->prefix(function (callable $get) {
                                return $get('discount_type') === 'percentage' ? '%' : 'Rp';
                            })
                            ->minValue(0)
                            ->maxValue(function (callable $get) {
                                return $get('discount_type') === 'percentage' ? 100 : 999999999;
                            }),
                    ])->columns(2),

                Schemas\Components\Section::make('Periode Aktif')
                    ->schema([
                        Forms\Components\DateTimePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->required()
                            ->native(false)
                            ->displayFormat('d M Y H:i'),
                        Forms\Components\DateTimePicker::make('end_date')
                            ->label('Tanggal Selesai')
                            ->required()
                            ->native(false)
                            ->displayFormat('d M Y H:i')
                            ->afterOrEqual('start_date')
                            ->rule(function (callable $get, $record) {
                                return function ($attribute, $value, $fail) use ($get, $record) {
                                    $productIds = $get('products') ?? [];
                                    if (empty($productIds)) return;

                                    $recordId = $record?->id;
                                    $start = $get('start_date');

                                    $overlap = Promo::where('is_active', true)
                                        ->where(function ($q) use ($start, $value) {
                                            $q->whereBetween('start_date', [$start, $value])
                                                ->orWhereBetween('end_date', [$start, $value])
                                                ->orWhere(function ($q) use ($start, $value) {
                                                    $q->where('start_date', '<=', $start)
                                                        ->where('end_date', '>=', $value);
                                                });
                                        });

                                    if ($recordId) {
                                        $overlap->where('id', '!=', $recordId);
                                    }

                                    $overlapPromos = $overlap->whereHas('products', function ($q) use ($productIds) {
                                        $q->whereIn('products.id', $productIds);
                                    })->exists();

                                    if ($overlapPromos) {
                                        $fail('Periode promo ini bertabrakan dengan promo lain untuk produk yang sama. Periksa periode aktif promo lain.');
                                    }
                                };
                            }),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(3),

                Schemas\Components\Section::make('Produk Terkait')
                    ->description('Pilih produk yang mendapatkan promo ini')
                    ->schema([
                        Forms\Components\Select::make('products')
                            ->label('Produk')
                            ->relationship('products', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText('Pilih satu atau lebih produk yang termasuk dalam promo ini.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Promo')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('discount_type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'percentage' => 'danger',
                        'nominal' => 'warning',
                        'fixed_price' => 'success',
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'percentage' => 'Persentase',
                        'nominal' => 'Nominal',
                        'fixed_price' => 'Harga Tetap',
                    }),
                Tables\Columns\TextColumn::make('discount_value')
                    ->label('Nilai')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->discount_type === 'percentage'
                            ? $state . '%'
                            : 'Rp ' . number_format($state, 0, ',', '.');
                    }),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Mulai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('products_count')
                    ->label('Produk')
                    ->counts('products')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
                Tables\Filters\SelectFilter::make('discount_type')
                    ->label('Tipe Diskon')
                    ->options([
                        'percentage' => 'Persentase',
                        'nominal' => 'Nominal',
                        'fixed_price' => 'Harga Tetap',
                    ]),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPromos::route('/'),
            'create' => Pages\CreatePromo::route('/create'),
            'edit' => Pages\EditPromo::route('/{record}/edit'),
        ];
    }
}
