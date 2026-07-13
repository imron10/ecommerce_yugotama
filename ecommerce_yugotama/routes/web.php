<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\KatalogProduk;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredProducts = Product::with('category')
        ->where('is_active', true)
        ->whereNotNull('price')
        ->inRandomOrder()
        ->limit(8)
        ->get();

    $categories = Category::where('is_active', true)
        ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
        ->having('products_count', '>', 0)
        ->get();

    return view('welcome', compact('featuredProducts', 'categories'));
});

Route::get('/produk', KatalogProduk::class)->name('produk.katalog');


Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return view('dashboard');
    }
    return view('dashboard-buyer');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
