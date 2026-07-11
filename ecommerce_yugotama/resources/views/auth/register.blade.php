<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-heading font-bold text-neutral-900">Buat Akun Baru</h2>
        <p class="mt-1.5 text-sm text-neutral-500">Daftar gratis, mulai belanja di Yugotama Mart</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-neutral-700 mb-1.5">
                Nama Lengkap
            </label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                   placeholder="Contoh: Budi Santoso"
                   value="{{ old('name') }}"
                   class="block w-full px-4 py-3.5 bg-white border border-neutral-200 rounded-xl text-neutral-900 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all duration-200 text-base">
            @error('name')
                <p class="mt-1.5 text-sm text-danger-500 flex items-center gap-1.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-neutral-700 mb-1.5">
                Email <span class="text-neutral-400 font-normal">(atau nomor HP di bawah)</span>
            </label>
            <input id="email" type="email" name="email" :value="old('email')" autocomplete="email"
                   placeholder="nama@email.com"
                   value="{{ old('email') }}"
                   class="block w-full px-4 py-3.5 bg-white border border-neutral-200 rounded-xl text-neutral-900 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all duration-200 text-base">
            @error('email')
                <p class="mt-1.5 text-sm text-danger-500 flex items-center gap-1.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-medium text-neutral-700 mb-1.5">
                Nomor HP <span class="text-neutral-400 font-normal">(atau email di atas)</span>
            </label>
            <input id="phone" type="tel" name="phone" :value="old('phone')" autocomplete="tel"
                   placeholder="0812xxxxxxx"
                   value="{{ old('phone') }}"
                   class="block w-full px-4 py-3.5 bg-white border border-neutral-200 rounded-xl text-neutral-900 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:outline-none transition-all duration-200 text-base">
            @error('phone')
                <p class="mt-1.5 text-sm text-danger-500 flex items-center gap-1.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
            @if (!old('email') && !old('phone'))
                <p class="mt-1 text-xs text-neutral-400">Isi email ATAU nomor HP saja sudah cukup.</p>
            @endif
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-neutral-700 mb-1.5">
                Password
            </label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   placeholder="Minimal 8 karakter"
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

        <!-- Submit Button -->
        <button type="submit"
                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-primary-700 hover:bg-primary-600 active:bg-primary-800 rounded-xl font-semibold text-sm text-white tracking-wide focus:outline-none focus:ring-2 focus:ring-primary-500/40 transition-all duration-200 min-h-[44px] shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Daftar Gratis
        </button>

        <p class="text-xs text-neutral-400 text-center leading-relaxed">
            Dengan mendaftar, Anda menyetujui
            <a href="#" class="text-primary-600 hover:text-primary-700 underline">Syarat & Ketentuan</a>
            dan
            <a href="#" class="text-primary-600 hover:text-primary-700 underline">Kebijakan Privasi</a>
            Yugotama Mart.
        </p>

        <!-- Login Link -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-neutral-100"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-neutral-400">atau</span>
            </div>
        </div>
        <p class="text-center text-sm text-neutral-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-semibold transition-colors">
                Masuk di sini
            </a>
        </p>
    </form>
</x-guest-layout>
