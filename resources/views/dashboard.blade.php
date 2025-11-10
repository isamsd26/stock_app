@extends('layouts.base', ['title' => 'Dashboard'])

@section('content')

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="rounded-2xl p-6 bg-gradient-to-br from-indigo-600 to-violet-600 text-white shadow-lg">
            <p class="text-sm/5 opacity-90">Total Produk</p>
            <p class="text-4xl font-semibold mt-2">{{ \App\Models\Product::count() }}</p>
        </div>
        <div class="card card-pad">
            <p class="text-sm text-slate-500 dark:text-slate-400">Stok &lt; Min</p>
            <p class="text-3xl font-semibold mt-2">{{ \App\Models\Product::whereColumn('stock', '<', 'min_stock')->count() }}
            </p>
        </div>
        <div class="card card-pad">
            <p class="text-sm text-slate-500 dark:text-slate-400">Nilai Persediaan</p>
            <p class="text-3xl font-semibold mt-2">
                Rp
                {{ number_format(\App\Models\Product::selectRaw('SUM(stock * purchase_price) v')->value('v') ?? 0, 0, ',', '.') }}
            </p>
        </div>
        <div class="card card-pad">
            <p class="text-sm text-slate-500 dark:text-slate-400">Tanggal</p>
            <p class="text-2xl font-semibold mt-2">{{ now()->format('d M Y') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 card card-pad">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Aksi Cepat</h3>
                <a class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline"
                    href="{{ route('reports.stock') }}">Laporan →</a>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('products.create') }}" class="btn-pri">Tambah Produk</a>
                <a href="{{ route('transactions.history') }}" class="btn-sec">Transaksi</a>
                <a href="{{ route('categories.index') }}" class="btn-ghost">Kelola Kategori</a>
            </div>
        </div>

        <div class="card card-pad">
            <h3 class="text-lg font-semibold mb-4">Produk Hampir Habis</h3>
            <ul class="divide-y divide-slate-200/70 dark:divide-slate-700/50 text-sm">
                @foreach (\App\Models\Product::whereColumn('stock', '<', 'min_stock')->latest()->take(6)->get() as $p)
                    <li class="py-2 flex justify-between">
                        <span>{{ $p->name }}</span>
                        <span
                            class="badge bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-200">{{ $p->stock }}</span>
                    </li>
                @endforeach
                @if (\App\Models\Product::whereColumn('stock', '<', 'min_stock')->count() === 0)
                    <li class="py-2 text-slate-500">Semua aman 🎉</li>
                @endif
            </ul>
        </div>
    </div>
@endsection
