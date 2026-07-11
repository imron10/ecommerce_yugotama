@props([
    'product',
    'showBranch' => null,
    'showAddToCart' => false,
    'originalPrice' => null,
])

<div {{ $attributes->merge(['class' => 'group bg-white rounded-xl border border-neutral-100 shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden']) }}>
    <!-- Product Image (1:1 ratio) -->
    <div class="relative aspect-square bg-neutral-50 flex items-center justify-center overflow-hidden">
        @if($product->image ?? false)
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-4">
        @else
            <div class="w-16 h-16 rounded-xl bg-white shadow-sm flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        @endif

        <!-- Promo Badge Slot -->
        {{ $slot ?? '' }}

        @if($originalPrice)
            <!-- SKU Badge -->
            <div class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-white/90 text-[11px] font-mono text-neutral-500 shadow-sm">
                {{ $product->sku }}
            </div>
        @endif
    </div>

    <!-- Product Info -->
    <div class="p-3 sm:p-4">
        <!-- Category -->
        @if($product->category)
            <p class="text-xs font-medium text-primary-500 mb-0.5">{{ $product->category->name }}</p>
        @endif

        <!-- Name -->
        <h3 class="font-semibold text-neutral-900 text-sm leading-snug group-hover:text-primary-700 transition-colors truncate-2">
            {{ $product->name }}
        </h3>

        <!-- Unit -->
        <p class="text-xs text-neutral-400 mt-0.5">{{ $product->unit }}</p>

        <!-- Price -->
        <div class="mt-2">
            @php
                $price = $showBranch
                    ? $product->prices->firstWhere('branch_id', $showBranch)
                    : $product->prices->first();
                $displayPrice = $price?->price;
                $hasPromo = $originalPrice && $displayPrice && $originalPrice > $displayPrice;
            @endphp
            @if($displayPrice)
                <div class="flex items-baseline gap-1.5 flex-wrap">
                    @if($hasPromo)
                        <span class="text-xs text-neutral-400 line-through">Rp{{ number_format($originalPrice, 0, ',', '.') }}</span>
                    @endif
                    <span class="text-base sm:text-lg font-bold text-primary-700">Rp{{ number_format($displayPrice, 0, ',', '.') }}</span>
                </div>
            @else
                <p class="text-sm text-neutral-400 italic">Hubungi untuk harga</p>
            @endif
        </div>

        @if($showAddToCart)
            <button class="mt-3 w-full py-2.5 rounded-lg bg-primary-700 text-white text-sm font-medium hover:bg-primary-700/90 active:bg-primary-700/80 transition-colors duration-150 min-h-[44px] flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>+ Keranjang</span>
            </button>
        @endif
    </div>
</div>
