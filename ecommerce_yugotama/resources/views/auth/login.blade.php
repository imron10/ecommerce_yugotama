<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-heading font-bold text-neutral-900">Selamat Datang Kembali</h2>
        <p class="mt-1.5 text-sm text-neutral-500">Masuk ke akun Yugotama Mart Anda</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 p-3 rounded-lg bg-success-500/10 border border-success-500/20 text-sm text-success-700">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Login (Email or Phone) -->
        <div>
            <label for="login" class="block text-sm font-medium text-neutral-700 mb-1.5">
                Email atau Nomor HP
            </label>
            <input id="login" type="text" name="login" :value="old('login')" required autofocus autocomplete="username"
                   placeholder="nama@email.com atau 0812xxxxxxx"
                   value="{{ old('login') }}"
                   class="block w-full px-4 py-3.5 bg-white border border-neutral-200 rounded-xl text-neutral-900 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all duration-200 text-base">
            @error('login')
                <p class="mt-1.5 text-sm text-danger-500 flex items-center gap-1.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-medium text-neutral-700">
                    Password
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium transition-colors">
                        Lupa password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   placeholder="Masukkan password"
                   class="block w-full px-4 py-3.5 bg-white border border-neutral-200 rounded-xl text-neutral-900 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all duration-200 text-base">
            @error('password')
                <p class="mt-1.5 text-sm text-danger-500 flex items-center gap-1.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center gap-2.5 cursor-pointer select-none">
                <input id="remember_me" type="checkbox" name="remember"
                       class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-500/30 focus:ring-offset-0 cursor-pointer transition-all">
                <span class="text-sm text-neutral-600">Ingat saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit"
                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-primary-700 hover:bg-primary-600 active:bg-primary-800 rounded-xl font-semibold text-sm text-white tracking-wide focus:outline-none focus:ring-2 focus:ring-primary-500/40 transition-all duration-200 min-h-[44px] shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            Masuk
        </button>

        <!-- Register Link -->
        @if (Route::has('register'))
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-neutral-100"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-neutral-400">atau</span>
                </div>
            </div>
            <p class="text-center text-sm text-neutral-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-semibold transition-colors">
                    Daftar sekarang
                </a>
            </p>
        @endif
    </form>
</x-guest-layout>
