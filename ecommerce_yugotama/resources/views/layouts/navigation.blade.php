<nav class="bg-white border-b border-neutral-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Left: Logo & Desktop Nav -->
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 shrink-0">
                    <div class="w-8 h-8 rounded-lg bg-primary-700 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-heading font-bold text-neutral-900">Yugotama Mart</span>
                </a>
            </div>

            <!-- Right: Avatar Dropdown & Mobile Toggle -->
            <div class="flex items-center md:order-2 space-x-3 md:space-x-3">
                @auth
                    <!-- User Avatar Dropdown -->
                    <button type="button"
                        class="flex items-center text-sm bg-neutral-100 rounded-full focus:ring-4 focus:ring-neutral-200"
                        id="user-menu-button"
                        data-dropdown-toggle="user-dropdown"
                        aria-expanded="false">
                        <span class="sr-only">Open user menu</span>
                        <div class="relative w-8 h-8 overflow-hidden bg-primary-700 rounded-full flex items-center justify-center text-white font-semibold text-xs">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-neutral-100 rounded-xl shadow-lg border border-neutral-100"
                        id="user-dropdown">
                        <div class="px-4 py-3">
                            <span class="block text-sm font-medium text-neutral-900">{{ Auth::user()->name }}</span>
                            <span class="block text-sm text-neutral-500 truncate">{{ Auth::user()->email }}</span>
                        </div>
                        <ul class="py-2">
                            <li>
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-2 px-4 py-2 text-sm text-neutral-700 hover:bg-primary-100 hover:text-primary-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ __('Profile') }}
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-2 w-full px-4 py-2 text-sm text-neutral-700 hover:bg-primary-100 hover:text-primary-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-neutral-600 hover:text-primary-700 transition-colors">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="text-sm font-medium px-4 py-2 rounded-lg bg-primary-700 text-white hover:bg-primary-700/90 transition-colors min-h-[44px] inline-flex items-center">
                            Register
                        </a>
                    @endif
                @endauth

                <!-- Mobile Menu Toggle -->
                <button data-collapse-toggle="navbar-user"
                    type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-neutral-500 rounded-lg md:hidden hover:bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-neutral-200"
                    aria-controls="navbar-user"
                    aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
                <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-neutral-100 rounded-lg bg-neutral-50 md:space-x-8 md:flex-row md:mt-0 md:border-0 md:bg-white">
                    <li>
                        <a href="{{ route('produk.katalog') }}"
                            class="block py-2 px-3 rounded md:bg-transparent md:p-0 {{ request()->routeIs('produk.katalog') ? 'text-primary-700 font-semibold' : 'text-neutral-600 hover:text-primary-700' }} transition-colors"
                            @if(request()->routeIs('produk.katalog')) aria-current="page" @endif>
                            Katalog
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="block py-2 px-3 rounded md:bg-transparent md:p-0 {{ request()->routeIs('dashboard') ? 'text-primary-700 font-semibold' : 'text-neutral-600 hover:text-primary-700' }} transition-colors"
                            @if(request()->routeIs('dashboard')) aria-current="page" @endif>
                            Dashboard
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('profile.edit') }}"
                                class="block py-2 px-3 rounded md:bg-transparent md:p-0 {{ request()->routeIs('profile.edit') ? 'text-primary-700 font-semibold' : 'text-neutral-600 hover:text-primary-700' }} transition-colors"
                                @if(request()->routeIs('profile.edit')) aria-current="page" @endif>
                                Profile
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</nav>
