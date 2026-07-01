<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — {{ config('app.name') }}</title>
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
<body class="bg-rose-50 min-h-screen flex items-center justify-center p-6 dark:bg-gray-950 transition-colors duration-200">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-8 dark:bg-gray-900 dark:border-rose-900/30 dark:shadow-none">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-rose-900 dark:text-rose-300">Glow &amp; Grace</h1>
                <p class="text-sm text-rose-500 mt-1" data-i18n="admin.login.subtitle">Sign in to manage your store</p>
            </div>

            <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.login.email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-rose-700 mb-1 dark:text-rose-300" data-i18n="admin.login.password">Password</label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-4 py-2.5 border border-rose-200 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:focus:ring-rose-400 dark:focus:border-rose-400">
                </div>

                {{-- Remember --}}
                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember"
                           class="rounded border-rose-300 text-rose-500 focus:ring-rose-500 dark:border-gray-600 dark:bg-gray-800 dark:focus:ring-rose-400">
                    <label for="remember" class="ml-2 text-sm text-rose-600 dark:text-rose-400" data-i18n="admin.login.remember">Remember me</label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-rose-500 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-rose-600 transition shadow-sm shadow-rose-200 dark:shadow-none dark:hover:bg-rose-700">
                    <span data-i18n="admin.login.button">Sign In</span>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
