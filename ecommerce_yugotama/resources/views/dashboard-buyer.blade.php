<x-app-layout>
    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-heading font-bold text-neutral-900">Dashboard</h1>
                    <p class="mt-1 text-sm text-neutral-500">
                        Selamat datang kembali, <span class="text-primary-700 font-semibold">{{ Auth::user()->name }}</span>
                    </p>
                </div>
                <a href="{{ route('produk.katalog') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary-700 text-white text-sm font-medium shadow-sm hover:bg-primary-700/90 transition-all min-h-[44px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Belanja Sekarang
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- LEFT: Member Card + Info --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Digital Member Card --}}
                    <div class="relative rounded-xl bg-gradient-to-br from-primary-700 to-primary-500 p-5 text-white overflow-hidden shadow-sm">
                        <div class="absolute inset-0 opacity-10"
                             style="background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.3) 1px, transparent 1px); background-size: 20px 20px;">
                        </div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-xs text-white/70 font-medium">Yugotama Mart Member</p>
                                <span class="text-xs bg-white/20 rounded-full px-2.5 py-0.5 font-medium">Reguler</span>
                            </div>
                            <p class="text-lg font-heading font-bold tracking-tight">{{ Auth::user()->name }}</p>
                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                <span class="text-xs bg-white/20 rounded-md px-2.5 py-1 font-mono tracking-wider">
                                    YM-{{ str_pad(Auth::user()->id, 6, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="text-xs bg-accent-500/30 rounded-md px-2.5 py-1">
                                    Poin: <strong>{{ number_format(0, 0, ',', '.') }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Stats --}}
                    <div class="bg-white rounded-xl border border-neutral-100 shadow-sm p-5">
                        <h2 class="text-sm font-heading font-semibold text-neutral-900 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Ringkasan
                        </h2>
                        @php
                            $stats = [
                                ['label' => 'Total Pesanan', 'value' => \App\Models\Order::where('user_id', Auth::id())->count()],
                                ['label' => 'Menunggu Verifikasi', 'value' => \App\Models\Order::where('user_id', Auth::id())->where('payment_status', 'pending')->count()],
                                ['label' => 'Selesai', 'value' => \App\Models\Order::where('user_id', Auth::id())->where('status', 'delivered')->count()],
                            ];
                        @endphp
                        <div class="space-y-3">
                            @foreach($stats as $s)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-neutral-600">{{ $s['label'] }}</span>
                                    <span class="text-sm font-bold text-primary-700">{{ $s['value'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Recent Orders --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl border border-neutral-100 shadow-sm p-5">
                        <h2 class="text-sm font-heading font-semibold text-neutral-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            Riwayat Pesanan
                        </h2>

                        @php
                            $orders = \App\Models\Order::where('user_id', Auth::id())
                                ->latest()
                                ->limit(10)
                                ->get();
                        @endphp

                        @if($orders->count() > 0)
                            <div class="overflow-x-auto -mx-5">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="bg-neutral-50 border-b border-neutral-100">
                                            <th class="text-left py-3 px-4 text-neutral-500 font-medium">Pesanan</th>
                                            <th class="text-right py-3 px-4 text-neutral-500 font-medium">Total</th>
                                            <th class="text-center py-3 px-4 text-neutral-500 font-medium">Status</th>
                                            <th class="text-right py-3 px-4 text-neutral-500 font-medium hidden md:table-cell">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr class="border-b border-neutral-50 hover:bg-neutral-50 transition-colors">
                                                <td class="py-3 px-4">
                                                    <span class="font-mono text-xs font-medium text-neutral-900">{{ $order->order_number }}</span>
                                                </td>
                                                <td class="py-3 px-4 text-right font-semibold text-primary-700">
                                                    Rp{{ number_format($order->total, 0, ',', '.') }}
                                                </td>
                                                <td class="py-3 px-4 text-center">
                                                    @php
                                                        $statusStyles = [
                                                            'pending' => ['text' => 'Menunggu', 'color' => 'bg-yellow-100 text-yellow-700'],
                                                            'verified' => ['text' => 'Diverifikasi', 'color' => 'bg-blue-100 text-blue-700'],
                                                            'processing' => ['text' => 'Diproses', 'color' => 'bg-yellow-100 text-yellow-700'],
                                                            'shipped' => ['text' => 'Dikirim', 'color' => 'bg-blue-100 text-blue-700'],
                                                            'delivered' => ['text' => 'Selesai', 'color' => 'bg-green-100 text-green-700'],
                                                            'cancelled' => ['text' => 'Dibatalkan', 'color' => 'bg-red-100 text-red-700'],
                                                        ];
                                                        $style = $statusStyles[$order->status] ?? ['text' => $order->status, 'color' => 'bg-neutral-100 text-neutral-600'];
                                                    @endphp
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $style['color'] }}">
                                                        {{ $style['text'] }}
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4 text-right text-neutral-500 text-xs hidden md:table-cell">
                                                    {{ $order->created_at->format('d M Y H:i') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-14 h-14 mx-auto rounded-full bg-neutral-100 flex items-center justify-center mb-3">
                                    <svg class="w-7 h-7 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-neutral-500 mb-1">Belum ada pesanan</p>
                                <p class="text-xs text-neutral-400">Mulai belanja untuk melihat riwayat pesanan Anda.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
