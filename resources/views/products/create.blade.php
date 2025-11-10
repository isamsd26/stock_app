@extends('layouts.base')
@section('content')
    @include('partials.page', ['title' => 'Tambah Produk'])

    <div class="bg-white rounded-2xl shadow p-6 max-w-3xl text-black">
        <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <div>
                <label class="block text-sm mb-1">Kategori</label>
                <select name="category_id" required
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Pilih...</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Nama</label>
                <input name="name" required
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm mb-1">Satuan</label>
                <input name="unit" value="pcs" required class="w-full rounded-lg border-slate-300">
            </div>
            <div>
                <label class="block text-sm mb-1">Harga Beli</label>
                <input type="number" name="purchase_price" step="0.01" class="w-full rounded-lg border-slate-300">
            </div>
            <div>
                <label class="block text-sm mb-1">Harga Jual</label>
                <input type="number" name="selling_price" step="0.01" class="w-full rounded-lg border-slate-300">
            </div>
            <div>
                <label class="block text-sm mb-1">Min Stock</label>
                <input type="number" name="min_stock" value="0" class="w-full rounded-lg border-slate-300">
            </div>
            <div>
                <label class="block text-sm mb-1">Max Stock</label>
                <input type="number" name="max_stock" class="w-full rounded-lg border-slate-300">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border-slate-300"></textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Gambar</label>
                <input type="file" name="image" class="rounded-lg border-slate-300">
            </div>
            <div class="md:col-span-2 flex gap-3">
                <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white">Simpan</button>
                <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-lg border">Batal</a>
            </div>
        </form>
    </div>
@endsection
