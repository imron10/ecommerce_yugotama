<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Yugotama Mart') }} — Belanja Mudah & Hemat</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-body antialiased bg-neutral-100 text-neutral-900">

    @auth
    {{-- ===== TOP UTILITY BAR (only for auth) ===== --}}
    <div class="bg-primary-700 text-white text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between py-1.5">
            <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Kirim ke: <span class="font-semibold">Samarinda</span>
            </span>
            <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Bantuan: <span class="font-semibold">0800-1-234-567</span>
            </span>
        </div>
    </div>
    @endauth

    {{-- ===== HEADER ===== --}}
    <header class="bg-white border-b border-neutral-100 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2 shrink-0">
                    <div class="w-9 h-9 rounded-lg bg-primary-700 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <span class="text-base sm:text-lg font-heading font-bold text-neutral-900 hidden sm:inline">Yugotama Mart</span>
                </a>

                <!-- Search Bar (prominent, always visible) -->
                <div class="flex-1 relative">
                    <form action="{{ route('produk.katalog') }}" method="GET" class="w-full">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" name="search" placeholder="Cari beras, minyak goreng, susu..."
                                   class="w-full pl-10 pr-4 py-2.5 sm:py-3 rounded-lg border border-neutral-200 bg-neutral-50 text-sm text-neutral-900 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent focus:bg-white transition-all duration-200 min-h-[44px]">
                        </div>
                    </form>
                </div>

                <!-- Right Icons -->
                <div class="flex items-center gap-2 sm:gap-3">
                    @auth
                        <!-- Digital Member Card Trigger -->
                        <button type="button" onclick="document.getElementById('member-card').classList.toggle('hidden')"
                                class="hidden sm:flex items-center gap-1.5 px-3 py-2 rounded-lg border border-neutral-200 text-sm text-neutral-600 hover:bg-primary-100 hover:border-primary-300 hover:text-primary-700 transition-all duration-200 min-h-[44px]"
                                aria-label="Kartu Member">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                            </svg>
                            <span class="text-xs font-medium">Member</span>
                        </button>

                        <!-- Account Icon -->
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-1.5 px-3 py-2 rounded-lg border border-neutral-200 text-sm text-neutral-600 hover:bg-primary-100 hover:border-primary-300 hover:text-primary-700 transition-all duration-200 min-h-[44px]"
                           aria-label="Akun saya">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-xs font-medium hidden sm:inline">Akun</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm text-neutral-600 hover:text-primary-700 hover:bg-primary-100 transition-all duration-200 min-h-[44px]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-xs font-medium">Masuk</span>
                        </a>
                    @endauth

                    <!-- Cart Icon with Badge -->
                    <a href="{{ route('produk.katalog') }}"
                       class="relative flex items-center gap-1.5 px-3 py-2 rounded-lg border border-neutral-200 text-sm text-neutral-600 hover:bg-primary-100 hover:border-primary-300 hover:text-primary-700 transition-all duration-200 min-h-[44px]"
                       aria-label="Keranjang">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                        </svg>
                        <span class="text-xs font-medium hidden sm:inline">Keranjang</span>
                        @if(session()->has('cart_count') && session('cart_count') > 0)
                            <span class="absolute -top-1.5 -right-1.5 bg-danger-500 text-white text-[10px] font-bold min-w-[18px] h-[18px] rounded-full flex items-center justify-center px-1 shadow-sm">
                                {{ session('cart_count') }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- ===== DIGITAL MEMBER CARD (auth only) ===== --}}
    @auth
    <div id="member-card" class="hidden max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
        <div class="relative rounded-xl bg-gradient-to-br from-primary-700 to-primary-500 p-5 text-white overflow-hidden">
            <!-- Pattern overlay -->
            <div class="absolute inset-0 opacity-10"
                 style="background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.3) 1px, transparent 1px); background-size: 20px 20px;">
            </div>
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-xs text-white/70 mb-1">Yugotama Mart Member</p>
                    <p class="text-lg font-heading font-bold tracking-tight">{{ Auth::user()->name }}</p>
                    <div class="mt-2 flex items-center gap-3">
                        <span class="text-xs bg-white/20 rounded-md px-2 py-1 font-mono tracking-wider">YM-{{ str_pad(Auth::user()->id, 6, '0', STR_PAD_LEFT) }}</span>
                        <span class="text-xs bg-accent-500/30 rounded-md px-2 py-1">
                            Poin: <strong>{{ number_format(0, 0, ',', '.') }}</strong>
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs text-white/70">Member</p>
                    <span class="text-xs bg-white/20 rounded-full px-3 py-1 mt-1 inline-block">Reguler</span>
                </div>
            </div>
        </div>
    </div>
    @endauth

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- ===== HERO BANNER (guest only) ===== --}}
        @guest
        <div class="bg-white rounded-xl border border-neutral-100 shadow-sm p-6 sm:p-8 mb-6">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-100 text-primary-700 text-xs font-medium mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>
                    E-Commerce Samarinda
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-heading font-bold text-neutral-900 leading-tight">
                    Belanja Kebutuhan <span class="text-primary-700">Pokok & Harian</span>
                </h1>
                <p class="mt-2 text-sm sm:text-base text-neutral-500 max-w-lg">
                    Produk berkualitas dengan harga terbaik. Belanja dari rumah, kami antar ke pintu Anda.
                </p>
                <div class="mt-4 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('produk.katalog') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-primary-700 text-white font-semibold text-sm shadow-sm hover:bg-primary-700/90 transition-colors min-h-[44px]">
                        <span>Lihat Katalog</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg border border-neutral-200 text-neutral-700 font-semibold text-sm hover:bg-neutral-50 hover:border-neutral-300 transition-colors min-h-[44px]">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        Daftar Gratis
                    </a>
                </div>
            </div>
        </div>
        @endguest

        {{-- ===== PROMO BANNERS (dinamis) ===== --}}
        @php
            $promos = [
                ['scheme' => '5 Sip', 'title' => 'Promo 5 Sip', 'desc' => 'Beli 5 produk, hemat ekstra 5%', 'color' => 'from-amber-500 to-orange-500'],
                ['scheme' => 'Semur', 'title' => 'Promo Semur', 'desc' => 'Sembako murah — diskon hingga 15%', 'color' => 'from-emerald-500 to-teal-500'],
                ['scheme' => 'Beweekly', 'title' => 'Beweekly Sale', 'desc' => 'Promo dua-mingguan — produk pilihan', 'color' => 'from-violet-500 to-purple-500'],
                ['scheme' => 'Gantung', 'title' => 'Gantung Promo', 'desc' => 'Harga spesial — stok terbatas!', 'color' => 'from-rose-500 to-pink-500'],
            ];
            $activePromo = $promos[array_rand($promos)];
        @endphp

        <div class="mb-6">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-heading font-bold text-neutral-900 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-accent-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Promo Aktif
                </h2>
                <div class="flex gap-1.5">
                    @foreach($promos as $p)
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $p['scheme'] === $activePromo['scheme'] ? 'bg-accent-100 text-accent-500' : 'bg-neutral-100 text-neutral-400' }}">
                            {{ $p['scheme'] }}
                        </span>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('produk.katalog') }}" class="block">
                <div class="relative overflow-hidden rounded-xl bg-gradient-to-r {{ $activePromo['color'] }} p-5 text-white shadow-sm">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-bold bg-white/20 rounded-full px-2 py-0.5">{{ $activePromo['scheme'] }}</span>
                            </div>
                            <p class="text-lg sm:text-xl font-heading font-bold">{{ $activePromo['title'] }}</p>
                            <p class="text-sm text-white/80 mt-0.5">{{ $activePromo['desc'] }}</p>
                        </div>
                        <span class="text-sm font-semibold bg-white/20 rounded-lg px-4 py-2 whitespace-nowrap">Lihat</span>
                    </div>
                </div>
            </a>
        </div>

        {{-- ===== CATEGORIES (horizontal scroll) ===== --}}
        <div class="mb-6">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-heading font-bold text-neutral-900">Kategori</h2>
                <a href="{{ route('produk.katalog') }}" class="text-xs font-medium text-primary-700 hover:text-primary-500 transition-colors">Lihat Semua</a>
            </div>
            <div class="flex gap-3 overflow-x-auto pb-2 -mx-4 px-4 snap-x snap-mandatory scrollbar-hide">
                @foreach ($categories as $category)
                <a href="{{ route('produk.katalog', ['kategori' => $category->slug]) }}"
                   class="flex flex-col items-center gap-1.5 min-w-[80px] sm:min-w-[90px] p-3 rounded-xl bg-white border border-neutral-100 shadow-sm hover:shadow-md hover:border-primary-200 hover:-translate-y-0.5 transition-all duration-200 snap-start">
                    <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center">
                        @switch($category->slug)
                            @case('beras-tepung')
                                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                @break
                            @default
                                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        @endswitch
                    </div>
                    <span class="text-[11px] font-medium text-neutral-700 text-center leading-tight">{{ $category->name }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- ===== PRODUCT GRID ===== --}}
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-sm font-heading font-bold text-neutral-900">Produk Tersedia</h2>
            <a href="{{ route('produk.katalog') }}" class="text-xs font-medium text-primary-700 hover:text-primary-500 transition-colors flex items-center gap-1">
                Lihat Semua
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-4 mb-8">
            @forelse ($featuredProducts as $product)
                <div>                        @php
                        // Simulasi harga promo (nanti dari DB)
                        $originalPrice = $product->price;
                        if ($originalPrice && $loop->index < 2) {
                            $originalPrice = round($originalPrice * 1.15 / 100) * 100; // 15% di atas harga promo
                        } else {
                            $originalPrice = null;
                        }
                    @endphp
                    <x-product-card :product="$product" showAddToCart="true" :originalPrice="$originalPrice">
                        @if($originalPrice)
                            <x-promo-badge text="Promo" class="!absolute top-2 right-2" />
                        @endif
                    </x-product-card>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-14 h-14 mx-auto rounded-xl bg-neutral-100 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <p class="text-neutral-500">Belum ada produk tersedia</p>
                </div>
            @endforelse
        </div>

    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-neutral-900 text-neutral-400 py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                <div class="col-span-2 sm:col-span-1">
                    <a href="/" class="flex items-center gap-2 mb-3">
                        <div class="w-7 h-7 rounded-lg bg-primary-700 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="font-heading font-bold text-white text-sm">Yugotama Mart</span>
                    </a>
                    <p class="text-xs leading-relaxed">E-commerce kebutuhan pokok & harian terpercaya di Samarinda.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-neutral-300 text-xs mb-3">Belanja</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('produk.katalog') }}" class="text-xs hover:text-white transition-colors">Semua Produk</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-neutral-300 text-xs mb-3">Akun</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('login') }}" class="text-xs hover:text-white transition-colors">Masuk</a></li>
                        @if (Route::has('register'))
                        <li><a href="{{ route('register') }}" class="text-xs hover:text-white transition-colors">Daftar</a></li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-neutral-300 text-xs mb-3">Kontak</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-1.5 text-xs"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg> info@yugotama.com</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-neutral-800 text-center text-xs text-neutral-500">
                &copy; {{ date('Y') }} Yugotama Mart. Dibuat dengan <span class="text-red-400/60">&hearts;</span> di Samarinda.
            </div>
        </div>
    </footer>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    @livewireScripts
</body>
</html>
