<!doctype html>
<html lang="id">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name', 'Stock App') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="min-h-screen bg-gray-50 text-slate-800">
        {{-- Topbar --}}
        <header class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span
                        class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-indigo-600 text-white font-bold">S</span>
                    <a href="{{ route('dashboard') }}" class="font-semibold">Stock App</a>
                </div>
                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                    <a href="{{ route('categories.index') }}" class="hover:text-indigo-600">Kategori</a>
                    <a href="{{ route('products.index') }}" class="hover:text-indigo-600">Produk</a>
                    <a href="{{ route('suppliers.index') }}" class="hover:text-indigo-600">Supplier</a>
                    <a href="{{ route('transactions.history') }}" class="hover:text-indigo-600">Transaksi</a>
                    <a href="{{ route('reports.stock') }}" class="hover:text-indigo-600">Laporan</a>
                    <a href="{{ route('settings.index') }}" class="hover:text-indigo-600">Pengaturan</a>
                </nav>
                <div class="flex items-center gap-2">
                    @auth
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button
                                class="text-sm px-3 py-1.5 rounded-lg bg-slate-900 text-white hover:bg-slate-800">Keluar</button>
                        </form>
                    @endauth
                </div>
            </div>
        </header>

        {{-- Page --}}
        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @include('partials.flash')
                @yield('content')
            </div>
        </main>

        <footer class="py-6 text-center text-sm text-slate-500">
            &copy; {{ date('Y') }} {{ config('app.name', 'Stock App') }}. All rights reserved.
        </footer>
    </body>

</html>
