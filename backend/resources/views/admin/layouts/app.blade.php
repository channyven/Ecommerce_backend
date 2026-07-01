<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Flash-prevention: apply dark class before page renders --}}
    <script>
        (function() {
            var theme = localStorage.getItem('admin_theme');
            if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>
<body class="bg-rose-50 text-gray-900 antialiased dark:bg-gray-950 dark:text-gray-100 transition-colors duration-200">
    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        <aside class="w-64 bg-rose-900 text-white flex-shrink-0 hidden lg:block dark:bg-rose-950 dark:border-r dark:border-rose-900/50">
            <div class="p-6 border-b border-rose-800 dark:border-rose-900/50">
                <h1 class="text-lg font-bold tracking-tight">Glow &amp; Grace</h1>
                <p class="text-xs text-rose-300 mt-0.5" data-i18n="admin.panel">Admin Panel</p>
            </div>

            {{-- Logged-in User Info --}}
            <div class="px-4 pt-4 pb-2 border-b border-rose-800/50 dark:border-rose-900/30">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-rose-700 flex items-center justify-center text-white text-sm font-bold flex-shrink-0 overflow-hidden dark:bg-rose-800">
                        @if (Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-rose-300 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-rose-700 text-white dark:bg-rose-800' : 'text-rose-200 hover:bg-rose-800 hover:text-white dark:text-rose-300 dark:hover:bg-rose-900/60' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span data-i18n="admin.dashboard">Dashboard</span>
                </a>
                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.categories.*') ? 'bg-rose-700 text-white dark:bg-rose-800' : 'text-rose-200 hover:bg-rose-800 hover:text-white dark:text-rose-300 dark:hover:bg-rose-900/60' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                    <span data-i18n="admin.categories">Categories</span>
                </a>
                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.products.*') ? 'bg-rose-700 text-white dark:bg-rose-800' : 'text-rose-200 hover:bg-rose-800 hover:text-white dark:text-rose-300 dark:hover:bg-rose-900/60' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span data-i18n="admin.products">Products</span>
                </a>
                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.orders.*') ? 'bg-rose-700 text-white dark:bg-rose-800' : 'text-rose-200 hover:bg-rose-800 hover:text-white dark:text-rose-300 dark:hover:bg-rose-900/60' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    <span data-i18n="admin.orders">Orders</span>
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-rose-700 text-white dark:bg-rose-800' : 'text-rose-200 hover:bg-rose-800 hover:text-white dark:text-rose-300 dark:hover:bg-rose-900/60' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                    <span data-i18n="admin.customers">Customers</span>
                </a>

                <hr class="my-4 border-rose-800 dark:border-rose-900/50">

                {{-- Theme & Locale Toggles --}}
                <button id="theme-toggle"
                   class="flex items-center gap-3 w-full px-4 py-2.5 rounded-lg text-sm font-medium text-rose-300 hover:bg-rose-800 hover:text-white dark:text-rose-400 dark:hover:bg-rose-900/60 transition">
                    <svg id="theme-icon" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span data-i18n="admin.theme">Theme</span>
                </button>

                <button id="locale-toggle"
                   class="flex items-center gap-3 w-full px-4 py-2.5 rounded-lg text-sm font-bold text-rose-300 hover:bg-rose-800 hover:text-white dark:text-rose-400 dark:hover:bg-rose-900/60 transition">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span id="locale-label">KH</span>
                </button>

                <a href="{{ route('admin.logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-rose-300 hover:bg-rose-800 hover:text-white dark:text-rose-400 dark:hover:bg-rose-900/60 transition">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span data-i18n="admin.logout">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Top bar (mobile) --}}
            <header class="bg-white border-b border-rose-100 px-4 py-3 flex items-center justify-between lg:hidden dark:bg-gray-900 dark:border-gray-800">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-rose-200 flex items-center justify-center text-rose-800 text-xs font-bold flex-shrink-0 overflow-hidden dark:bg-rose-800 dark:text-rose-200">
                        @if (Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <span class="font-semibold text-sm text-rose-900 truncate dark:text-rose-300">{{ Auth::user()->name }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <button id="theme-toggle-mobile" onclick="toggleTheme()" class="p-1.5 rounded-lg hover:bg-rose-100 dark:hover:bg-gray-800 transition" title="Toggle theme">
                        <svg id="theme-icon-mobile" class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>
                    <button id="locale-toggle-mobile" onclick="setLocale(document.documentElement.lang === 'km' ? 'en' : 'km')" class="px-2 py-1 rounded-lg text-sm font-bold text-rose-600 hover:bg-rose-100 dark:text-rose-400 dark:hover:bg-gray-800 transition">KH</button>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button class="text-sm text-rose-600 hover:text-rose-800 dark:text-rose-400 dark:hover:text-rose-300 font-medium">Logout</button>
                    </form>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto p-6">
                {{-- Flash Messages --}}
                @if (session('success'))
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-lg text-sm dark:bg-rose-900/20 dark:border-rose-800/40 dark:text-rose-300">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm dark:bg-red-900/20 dark:border-red-800/40 dark:text-red-300">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
