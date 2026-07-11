<div>
    {{-- ===== HEADER ===== --}}
    <div class="bg-white border-b border-neutral-100 sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex items-center gap-3">
                <a href="/" class="flex items-center gap-2 shrink-0">
                    <div class="w-8 h-8 rounded-lg bg-primary-700 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <span class="text-sm sm:text-base font-heading font-bold text-neutral-900">Yugotama Mart</span>
                </a>

                <!-- Search -->
                <div class="flex-1 relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" placeholder="Cari produk..."
                           class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-neutral-200 bg-neutral-50 text-sm text-neutral-900 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent focus:bg-white transition-all duration-200 min-h-[44px]"
                           wire:model.live.debounce.300ms="search">
                </div>

                <!-- Cart Icon with Badge -->
                <a href="{{ route('produk.katalog') }}" class="relative flex items-center gap-1.5 px-3 py-2 rounded-lg border border-neutral-200 text-neutral-600 hover:bg-primary-100 hover:border-primary-300 hover:text-primary-700 transition-all min-h-[44px]" aria-label="Keranjang">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                    @if(session()->has('cart_count') && session('cart_count') > 0)
                        <span class="absolute -top-1.5 -right-1.5 bg-danger-500 text-white text-[10px] font-bold min-w-[18px] h-[18px] rounded-full flex items-center justify-center px-1 shadow-sm">
                            {{ session('cart_count') }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">

        <!-- Title -->
        <h1 class="text-lg sm:text-xl font-heading font-bold text-neutral-900 mb-1">Katalog Produk</h1>
        <p class="text-xs sm:text-sm text-neutral-500 mb-4">Temukan produk kebutuhan Anda dengan harga terbaik</p>

        <!-- Branch Selector -->
        <div class="mb-4">
            <label class="block text-xs font-medium text-neutral-600 mb-2">Pilih Cabang:</label>
            <div class="flex flex-wrap gap-2">
                @foreach($branches as $branch)
                    <button wire:click="selectBranch({{ $branch->id }})"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-lg text-xs sm:text-sm font-medium transition-all duration-200 min-h-[44px]
                                   {{ $branchId === $branch->id
                                       ? 'bg-primary-700 text-white shadow-sm'
                                       : 'bg-white text-neutral-700 border border-neutral-200 hover:border-primary-300 hover:text-primary-700' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $branch->name }}
                        <span class="text-[10px] opacity-70 hidden sm:inline">({{ $branch->code }})</span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Category Filter Pills (horizontal scroll) -->
        <div class="mb-4 overflow-x-auto scrollbar-hide -mx-4 px-4">
            <div class="flex gap-2 pb-1 min-w-max">
                <button wire:click="filterByCategory(null)"
                        class="px-4 py-2 rounded-full text-xs sm:text-sm font-medium transition-all duration-200 whitespace-nowrap min-h-[44px]
                               {{ $selectedCategory === null
                                   ? 'bg-neutral-900 text-white shadow-sm'
                                   : 'bg-neutral-100 text-neutral-600 hover:bg-neutral-200' }}">
                    Semua
                </button>
                @foreach($categories as $category)
                    <button wire:click="filterByCategory('{{ $category->slug }}')"
                            class="px-4 py-2 rounded-full text-xs sm:text-sm font-medium transition-all duration-200 whitespace-nowrap min-h-[44px]
                                   {{ $selectedCategory === $category->slug
                                       ? 'bg-primary-700 text-white shadow-sm'
                                       : 'bg-neutral-100 text-neutral-600 hover:bg-primary-100 hover:text-primary-700' }}">
                        {{ $category->name }}
                        <span class="ml-1 text-[10px] opacity-70">({{ $category->products_count }})</span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Product Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4">
                @foreach($products as $product)
                    <div wire:key="product-{{ $product->id }}">
                        <x-product-card :product="$product" :showBranch="$branchId" showAddToCart="true">
                            <x-promo-badge text="Promo" class="!absolute top-2 right-2" />
                        </x-product-card>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-neutral-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="text-base font-heading font-semibold text-neutral-900 mb-1">Produk tidak ditemukan</h3>
                <p class="text-xs sm:text-sm text-neutral-500 mb-4">Tidak ada produk yang sesuai dengan pencarian Anda.</p>
                <button wire:click="resetFilters"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-primary-700 rounded-lg hover:bg-primary-700/90 transition-all shadow-sm min-h-[44px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset Filter
                </button>
            </div>
        @endif
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</div>
