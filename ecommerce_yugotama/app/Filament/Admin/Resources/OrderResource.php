<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-shopping-bag';
    }
    protected static ?string $navigationLabel = 'Pesanan';
    protected static ?string $pluralModelLabel = 'Pesanan';
    protected static ?string $modelLabel = 'Pesanan';
    protected static ?int $navigationSort = 5;

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Schemas\Components\Section::make('Informasi Pesanan')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label('No. Pesanan')
                            ->disabled(),
                        Forms\Components\TextInput::make('user.name')
                            ->label('Pembeli')
                            ->disabled(),
                        Forms\Components\Select::make('status')
                            ->label('Status Pesanan')
                            ->options([
                                'pending' => 'Menunggu Verifikasi',
                                'verified' => 'Terverifikasi',
                                'processing' => 'Diproses',
                                'shipped' => 'Dikirim',
                                'delivered' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ])
                            ->required(),
                        Forms\Components\Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'pending' => 'Menunggu',
                                'verified' => 'Terverifikasi',
                                'rejected' => 'Ditolak',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan')
                            ->visible(fn(callable $get) => $get('payment_status') === 'rejected')
                            ->columnSpanFull(),
                    ])->columns(2),

                Schemas\Components\Section::make('Detail Pembayaran')
                    ->schema([
                        Forms\Components\TextInput::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->disabled()
                            ->formatStateUsing(fn($state) => $state === 'tunai' ? 'Tunai' : 'Nontunai'),
                        Forms\Components\TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->disabled()
                            ->money('IDR', locale: 'id'),
                        Forms\Components\TextInput::make('shipping_cost')
                            ->label('Ongkos Kirim')
                            ->disabled()
                            ->money('IDR', locale: 'id'),
                        Forms\Components\TextInput::make('discount')
                            ->label('Diskon')
                            ->disabled()
                            ->money('IDR', locale: 'id'),
                        Forms\Components\TextInput::make('total')
                            ->label('Total')
                            ->disabled()
                            ->money('IDR', locale: 'id')
                            ->weight('bold'),
                        Forms\Components\TextInput::make('notes')
                            ->label('Catatan')
                            ->disabled()
                            ->columnSpanFull(),
                    ])->columns(3),

                Schemas\Components\Section::make('Delivery')
                    ->schema([
                        Forms\Components\Textarea::make('delivery_address')
                            ->label('Alamat Pengiriman')
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('delivery_courier')
                            ->label('Kurir'),
                        Forms\Components\TextInput::make('delivery_tracking')
                            ->label('No. Tracking'),
                    ])->columns(2),

                Schemas\Components\Section::make('Item Pesanan')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->label('')
                            ->relationship('items')
                            ->schema([
                                Forms\Components\TextInput::make('product_name')
                                    ->label('Produk')
                                    ->disabled()
                                    ->columnSpan(4),
                                Forms\Components\TextInput::make('quantity')
                                    ->label('Qty')
                                    ->disabled()
                                    ->numeric()
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('unit_price')
                                    ->label('Harga Satuan')
                                    ->disabled()
                                    ->money('IDR', locale: 'id')
                                    ->columnSpan(3),
                                Forms\Components\TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->disabled()
                                    ->money('IDR', locale: 'id')
                                    ->columnSpan(3),
                            ])
                            ->columns(12)
                            ->columnSpanFull()
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('No. Pesanan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pembeli')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'verified' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => '⏳ Menunggu',
                        'verified' => '✅ Terverifikasi',
                        'rejected' => '❌ Ditolak',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'verified' => 'info',
                        'processing' => 'warning',
                        'shipped' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'verified' => 'Terverifikasi',
                        'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'delivered' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'pending' => 'Menunggu Verifikasi',
                        'verified' => 'Terverifikasi',
                        'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'delivered' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Menunggu',
                        'verified' => 'Terverifikasi',
                        'rejected' => 'Ditolak',
                    ]),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Metode Bayar')
                    ->options([
                        'tunai' => 'Tunai',
                        'nontunai' => 'Nontunai',
                    ]),
            ])
            ->actions([
                Actions\ActionGroup::make([
                    Actions\ViewAction::make()->label('Detail'),
                    Actions\Action::make('verify_payment')
                        ->label('✓ Verifikasi Pembayaran')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn(Order $record) => $record->payment_status === 'pending')
                        ->requiresConfirmation()
                        ->modalHeading('Verifikasi Pembayaran')
                        ->modalDescription('Pastikan bukti transfer sudah sesuai. Tandai pembayaran sebagai terverifikasi?')
                        ->action(function (Order $record) {
                            $record->update([
                                'payment_status' => 'verified',
                                'verified_at' => now(),
                                'verified_by' => auth()->id(),
                                'status' => 'processing',
                            ]);
                            Notification::make()
                                ->title('Pembayaran terverifikasi')
                                ->success()
                                ->send();
                        }),
                    Actions\Action::make('reject_payment')
                        ->label('✕ Tolak Pembayaran')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn(Order $record) => $record->payment_status === 'pending')
                        ->requiresConfirmation()
                        ->form([
                            Forms\Components\Textarea::make('rejection_reason')
                                ->label('Alasan Penolakan')
                                ->required()
                                ->maxLength(500),
                        ])
                        ->action(function (Order $record, array $data) {
                            $record->update([
                                'payment_status' => 'rejected',
                                'rejection_reason' => $data['rejection_reason'],
                                'status' => 'cancelled',
                            ]);
                            Notification::make()
                                ->title('Pembayaran ditolak')
                                ->danger()
                                ->send();
                        }),
                    Actions\Action::make('update_delivery')
                        ->label('🚚 Update Status Kirim')
                        ->icon('heroicon-o-truck')
                        ->color('primary')
                        ->visible(fn(Order $record) => in_array($record->status, ['processing', 'shipped']))
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('Status Pengiriman')
                                ->options([
                                    'processing' => 'Diproses',
                                    'shipped' => 'Dikirim',
                                    'delivered' => 'Selesai',
                                ])
                                ->required(),
                            Forms\Components\TextInput::make('delivery_courier')
                                ->label('Nama Kurir'),
                            Forms\Components\TextInput::make('delivery_tracking')
                                ->label('No. Tracking'),
                        ])
                        ->action(function (Order $record, array $data) {
                            $updateData = [
                                'status' => $data['status'],
                            ];
                            if (!empty($data['delivery_courier'])) {
                                $updateData['delivery_courier'] = $data['delivery_courier'];
                            }
                            if (!empty($data['delivery_tracking'])) {
                                $updateData['delivery_tracking'] = $data['delivery_tracking'];
                            }
                            if ($data['status'] === 'shipped') {
                                $updateData['shipped_at'] = now();
                            }
                            if ($data['status'] === 'delivered') {
                                $updateData['delivered_at'] = now();
                            }
                            $record->update($updateData);
                            Notification::make()
                                ->title('Status pengiriman diperbarui')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'items']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
