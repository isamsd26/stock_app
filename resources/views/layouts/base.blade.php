<!doctype html>
<html lang="id" class="h-full">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name', 'Stock App') }}</title>
        {{-- Inter font (opsional) --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"
            }
        </style>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            (function() {
                const html = document.documentElement;
                const saved = localStorage.getItem('theme');
                if (saved === 'dark') html.classList.add('dark');
                window.toggleTheme = () => {
                    html.classList.toggle('dark');
                    localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light')
                };
                window.toggleSidebar = (open) => {
                    document.getElementById('mobileSidebar').classList.toggle('hidden', !open)
                };
            })();
        </script>
    </head>

    <body class="h-full text-slate-900 dark:text-slate-100 admin-bg dark:bg-slate-900">

        {{-- DESKTOP SIDEBAR (≥ md) --}}
        <aside
            class="hidden md:flex fixed inset-y-0 left-0 w-72 z-40 flex-col bg-slate-900/95 backdrop-blur border-r border-slate-800">
            <div class="h-16 px-5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-indigo-600 text-white grid place-items-center font-bold">S</div>
                <div class="text-white font-semibold">{{ config('app.name', 'Stock App') }}</div>
            </div>

            @php
                $items = [
                    [
                        'label' => 'Dashboard',
                        'route' => 'dashboard',
                        'match' => 'dashboard',
                        'icon' => 'M3 12h18M12 3v18',
                    ],
                    [
                        'label' => 'Kategori',
                        'route' => 'categories.index',
                        'match' => 'categories.*',
                        'icon' => 'M3 6h18M3 12h12M3 18h8',
                    ],
                    [
                        'label' => 'Produk',
                        'route' => 'products.index',
                        'match' => 'products.*',
                        'icon' => 'M4 6h16v12H4zM8 10h8',
                    ],
                    [
                        'label' => 'Supplier',
                        'route' => 'suppliers.index',
                        'match' => 'suppliers.*',
                        'icon' => 'M4 6h16v10H4z M8 10h4',
                    ],
                    [
                        'label' => 'Transaksi',
                        'route' => 'transactions.history',
                        'match' => 'transactions.*',
                        'icon' => 'M5 7h14M5 12h14M5 17h14',
                    ],
                    [
                        'label' => 'Laporan Stok',
                        'route' => 'reports.stock',
                        'match' => 'reports.stock',
                        'icon' => 'M5 19v-6M12 19V5M19 19v-10',
                    ],
                    [
                        'label' => 'Mutasi',
                        'route' => 'reports.movement',
                        'match' => 'reports.movement',
                        'icon' => 'M4 12h16M10 6l-6 6 6 6',
                    ],
                    [
                        'label' => 'Penyesuaian',
                        'route' => 'reports.adjustments',
                        'match' => 'reports.adjustments',
                        'icon' => 'M12 4v16M4 12h16',
                    ],
                    [
                        'label' => 'Pengaturan',
                        'route' => 'settings.index',
                        'match' => 'settings.*',
                        'icon' => 'M12 8a4 4 0 100 8 4 4 0 000-8z M4 12h2M18 12h2',
                    ],
                ];
            @endphp

            <nav class="mt-2 px-3 space-y-1 text-sm">
                @foreach ($items as $it)
                    @php $active = request()->routeIs($it['match']); @endphp
                    <a href="{{ route($it['route']) }}" class="nav-link {{ $active ? 'nav-link-active' : '' }}">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-white" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="{{ $it['icon'] }}" />
                        </svg>
                        <span>{{ $it['label'] }}</span>
                        @if ($active)
                            <span class="ml-auto h-5 w-1 rounded bg-indigo-500"></span>
                        @endif
                    </a>
                @endforeach
            </nav>

            <div class="mt-auto p-4 text-xs text-slate-400">
                &copy; {{ date('Y') }} {{ config('app.name', 'Stock App') }}
            </div>
        </aside>

        {{-- MOBILE TOPBAR --}}
        <div
            class="md:hidden sticky top-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur border-b border-slate-200/70 dark:border-slate-800">
            <div class="h-14 px-4 flex items-center justify-between">
                <button class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800" onclick="toggleSidebar(true)">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-width="1.8" stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                </button>
                <div class="font-semibold">{{ $title ?? 'Dashboard' }}</div>
                <button class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800" onclick="toggleTheme()">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- MOBILE SIDEBAR --}}
        <div id="mobileSidebar" class="hidden md:hidden fixed inset-0 z-50">
            <div class="absolute inset-0 bg-black/40" onclick="toggleSidebar(false)"></div>
            <div class="absolute inset-y-0 left-0 w-72 bg-slate-900 text-white p-4">
                <div class="h-10 flex items-center justify-between mb-2">
                    <div class="font-semibold">{{ config('app.name', 'Stock App') }}</div>
                    <button class="p-2 rounded hover:bg-white/10" onclick="toggleSidebar(false)">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="1.8" stroke-linecap="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @foreach ($items as $it)
                    <a href="{{ route($it['route']) }}"
                        class="block px-3 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs($it['match']) ? 'bg-white/10' : '' }}">
                        {{ $it['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="md:pl-72">
            <header class="sticky top-0 z-30 bg-gradient-to-r from-indigo-600 to-violet-600 text-white">
                <div class="h-16 px-6 lg:px-8 flex items-center justify-between">
                    <div class="font-semibold text-lg">{{ $title ?? 'Dashboard' }}</div>
                    <div class="flex items-center gap-3">
                        <button onclick="toggleTheme()"
                            class="px-3 py-1.5 rounded-lg bg-white/20 hover:bg-white/25">Tema</button>
                        @auth
                            <form method="post" action="{{ route('logout') }}">
                                @csrf
                                <button class="px-3 py-1.5 rounded-lg bg-white/20 hover:bg-white/25">Keluar</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </header>

            <main class="p-6 lg:p-8 space-y-6">
                @include('partials.flash')
                @yield('content')
            </main>
        </div>
    </body>

</html>
