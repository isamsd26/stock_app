@extends('layouts.base', ['title' => 'Produk'])
@section('content')
    <div class="mb-5 flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Produk</h1>
        <a href="{{ route('products.create') }}" class="btn-pri">+ Tambah</a>
    </div>

    <div class="card card-pad">
        <form method="get" class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-3">
            <input name="s" value="{{ request('s') }}" placeholder="Cari nama/kode…" class="input">
            <select name="category_id" class="input">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
            <button class="btn-sec">Filter</button>
            <a href="{{ route('products.index') }}" class="btn-ghost">Reset</a>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-500 dark:text-slate-400">
                        <th class="py-2">Kode</th>
                        <th class="py-2">Nama</th>
                        <th class="py-2">Kategori</th>
                        <th class="py-2 text-right">Stok</th>
                        <th class="py-2 text-right">Harga Jual</th>
                        <th class="py-2 w-44">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/70 dark:divide-slate-700/50">
                    @foreach ($products as $p)
                        <tr>
                            <td class="py-2">{{ $p->product_code }}</td>
                            <td class="py-2">{{ $p->name }}</td>
                            <td class="py-2">{{ $p->category->name ?? '-' }}</td>
                            <td class="py-2 text-right">
                                <span
                                    class="badge {{ $p->stock < ($p->min_stock ?? 0) ? 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-200' : 'bg-slate-100 text-slate-700 dark:bg-slate-900/40 dark:text-slate-200' }}">
                                    {{ $p->stock }}
                                </span>
                            </td>
                            <td class="py-2 text-right">{{ number_format($p->selling_price, 0, ',', '.') }}</td>
                            <td class="py-2">
                                <a href="{{ route('products.edit', $p) }}"
                                    class="text-indigo-600 dark:text-indigo-400 hover:underline">Edit</a>
                                <form action="{{ route('products.destroy', $p) }}" method="post" class="inline"
                                    onsubmit="return confirm('Hapus produk?')">
                                    @csrf @method('DELETE')
                                    <button class="text-rose-600 dark:text-rose-400 hover:underline ml-3">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $products->links() }}</div>
    </div>
@endsection
