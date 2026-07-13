<?php

namespace App\Filament\Admin\Resources\ProductResource\Pages;

use App\Filament\Admin\Resources\ProductResource;
use App\Imports\ProductImport;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Produk'),

            Action::make('import_produk')
                ->label('Import Produk')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('primary')
                ->modalHeading('Import Produk dari CSV/Excel')
                ->modalDescription('Unggah file CSV atau Excel hasil ekspor dari Affari. Format: SKU, Nama Barang, Kategori, Satuan, Deskripsi. Produk dengan SKU yang sudah ada akan diperbarui.')
                ->modalSubmitActionLabel('Import')
                ->modalWidth('xl')
                ->form([
                    Section::make('Pilih File')
                        ->description('Format: CSV (.csv) atau Excel (.xlsx, .xls). Maksimal 5MB.')
                        ->schema([
                            FileUpload::make('file')
                                ->label('File Produk')
                                ->disk('local')
                                ->directory('imports')
                                ->acceptedFileTypes([
                                    'text/csv',
                                    'application/vnd.ms-excel',
                                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                ])
                                ->maxSize(5120)
                                ->required()
                                ->preserveFilenames()
                                ->helperText('Kolom: SKU, Nama Barang, Kategori, Satuan, Deskripsi (atau header Inggris: sku, name, category, unit, description)'),
                        ]),

                    Section::make('Contoh Format')
                        ->compact()
                        ->schema([
                            \Filament\Forms\Components\Placeholder::make('example')
                                ->label('')
                                ->content(function () {
                                    $sample = <<<'CSV'
sku,nama_barang,kategori,satuan
AGR-BRS-002,Beras Rojo Lele,Sembako,karung
SNK-QTO-001,Qtela 85g,Makanan Ringan,pcs
CSV;
                                    return '<pre class="text-xs bg-gray-100 p-3 rounded-lg overflow-x-auto">' . htmlspecialchars($sample) . '</pre>';
                                }),
                        ]),
                ])
                ->action(function (array $data) {
                    $filePath = $data['file'];

                    if (!$filePath) {
                        Notification::make()
                            ->title('Tidak ada file')
                            ->danger()
                            ->send();
                        return;
                    }

                    $fullPath = storage_path('app/' . $filePath);

                    if (!file_exists($fullPath)) {
                        Notification::make()
                            ->title('File tidak ditemukan')
                            ->danger()
                            ->send();
                        return;
                    }

                    try {
                        $import = new ProductImport();
                        Excel::import($import, $fullPath);

                        $result = $import->getResultMessage();

                        Notification::make()
                            ->title('Import Selesai')
                            ->body($result)
                            ->success()
                            ->send();

                        // Refresh the page to show new data
                        $this->redirect(request()->url(), navigate: true);
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Gagal Import')
                            ->body('Error: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
