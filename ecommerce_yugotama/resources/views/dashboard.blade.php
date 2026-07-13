<x-app-layout>
    <div class="py-8">
        <!-- Header -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-heading font-bold text-neutral-900">Dashboard</h1>
                    <p class="mt-1 text-neutral-500">Selamat datang kembali, <span class="text-primary-700 font-semibold">{{ Auth::user()->name }}</span></p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ url('/admin') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg border border-neutral-200 text-neutral-700 text-sm font-medium hover:bg-neutral-50 hover:border-neutral-300 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                        Panel Admin
                    </a>
                    <a href="{{ route('produk.katalog') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-primary-700 text-white text-sm font-medium shadow-sm hover:bg-primary-700/90 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Lihat Katalog
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @php
                    $stats = [
                        ['label' => 'Produk', 'value' => \App\Models\Product::count(), 'icon' => 'package'],
                        ['label' => 'Kategori', 'value' => \App\Models\Category::count(), 'icon' => 'grid'],
                        ['label' => 'Produk Aktif', 'value' => \App\Models\Product::where('is_active', true)->count(), 'icon' => 'check'],
                        ['label' => 'Harga Terisi', 'value' => \App\Models\Product::whereNotNull('price')->count(), 'icon' => 'money'],
                        ['label' => 'Pengguna', 'value' => \App\Models\User::count(), 'icon' => 'users'],
                    ];
                @endphp

                @foreach($stats as $stat)
                    <div class="bg-white rounded-xl border border-neutral-100 shadow-sm p-5">
                        <p class="text-2xl sm:text-3xl font-heading font-bold text-primary-700 tracking-tight">{{ $stat['value'] }}</p>
                        <p class="mt-1 text-sm text-neutral-500 font-medium">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions + Recent Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Quick Links -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl border border-neutral-100 shadow-sm p-6">
                        <h2 class="text-base font-heading font-semibold text-neutral-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Aksi Cepat
                        </h2>

                        <div class="space-y-2">
                            <a href="{{ url('/admin/kategori') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-lg bg-neutral-50 hover:bg-primary-100 border border-neutral-100 hover:border-primary-300 transition-all duration-200 group">
                                <div class="p-2 rounded-lg bg-primary-100">
                                    <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-neutral-700 group-hover:text-primary-700 transition-colors">Kelola Kategori</span>
                                <svg class="w-4 h-4 ml-auto text-neutral-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>

                            <a href="{{ url('/admin/produk') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-lg bg-neutral-50 hover:bg-primary-100 border border-neutral-100 hover:border-primary-300 transition-all duration-200 group">
                                <div class="p-2 rounded-lg bg-primary-100">
                                    <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-neutral-700 group-hover:text-primary-700 transition-colors">Kelola Produk</span>
                                <svg class="w-4 h-4 ml-auto text-neutral-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>

                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-lg bg-neutral-50 hover:bg-primary-100 border border-neutral-100 hover:border-primary-300 transition-all duration-200 group">
                                <div class="p-2 rounded-lg bg-primary-100">
                                    <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-neutral-700 group-hover:text-primary-700 transition-colors">Pengaturan Profil</span>
                                <svg class="w-4 h-4 ml-auto text-neutral-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Products -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl border border-neutral-100 shadow-sm p-6">
                        <h2 class="text-base font-heading font-semibold text-neutral-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            Produk Terbaru
                        </h2>

                        <div class="overflow-hidden rounded-lg border border-neutral-100">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="bg-neutral-50 border-b border-neutral-100">
                                        <th class="text-left py-3 px-4 text-neutral-500 font-medium">SKU</th>
                                        <th class="text-left py-3 px-4 text-neutral-500 font-medium">Nama Produk</th>
                                        <th class="text-left py-3 px-4 text-neutral-500 font-medium hidden sm:table-cell">Kategori</th>
                                        <th class="text-left py-3 px-4 text-neutral-500 font-medium hidden md:table-cell">Satuan</th>
                                        <th class="text-right py-3 px-4 text-neutral-500 font-medium hidden lg:table-cell">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(\App\Models\Product::with('category')->latest()->take(5)->get() as $product)
                                        <tr class="border-b border-neutral-50 hover:bg-neutral-50 transition-colors last:border-b-0">
                                            <td class="py-3 px-4">
                                                <span class="font-mono text-xs bg-neutral-100 text-neutral-600 px-2 py-1 rounded-md">{{ $product->sku }}</span>
                                            </td>
                                            <td class="py-3 px-4 text-neutral-900 font-medium">{{ $product->name }}</td>
                                            <td class="py-3 px-4 text-neutral-500 hidden sm:table-cell">{{ $product->category?->name ?? '-' }}</td>
                                            <td class="py-3 px-4 text-neutral-500 hidden md:table-cell">
                                                <span class="text-xs bg-neutral-100 text-neutral-600 px-2 py-1 rounded-md uppercase">{{ $product->unit }}</span>
                                            </td>
                                            <td class="py-3 px-4 text-right hidden lg:table-cell">
                                                @if($product->is_active)
                                                    <span class="inline-flex items-center gap-1 text-xs text-success-500">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-success-500"></span>
                                                        Aktif
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-xs text-danger-500">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-danger-500"></span>
                                                        Nonaktif
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-neutral-400">Belum ada produk</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Quick summary -->
                        <div class="mt-4 grid grid-cols-3 gap-3">
                            <div class="text-center p-3 rounded-lg bg-neutral-50 border border-neutral-100">
                                <p class="text-xl font-heading font-bold text-primary-700">{{ \App\Models\Category::where('is_active', true)->count() }}</p>
                                <p class="text-xs text-neutral-500 mt-1">Kategori Aktif</p>
                            </div>
                            <div class="text-center p-3 rounded-lg bg-neutral-50 border border-neutral-100">
                                <p class="text-xl font-heading font-bold text-primary-700">{{ \App\Models\Product::where('is_active', true)->count() }}</p>
                                <p class="text-xs text-neutral-500 mt-1">Produk Aktif</p>
                            </div>
                            <div class="text-center p-3 rounded-lg bg-neutral-50 border border-neutral-100">
                                <p class="text-xl font-heading font-bold text-primary-700">{{ \App\Models\Product::whereNotNull('price')->count() }}</p>
                                <p class="text-xs text-neutral-500 mt-1">Produk dengan Harga</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
