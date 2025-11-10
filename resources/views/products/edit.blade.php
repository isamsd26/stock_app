@extends('layouts.base')
@section('content')
    @include('partials.page', ['title' => 'Edit Produk'])

    <div class="bg-white rounded-2xl shadow p-6 max-w-3xl text-black">
        <form method="post" action="{{ route('products.update', $product) }}" enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm mb-1">Kategori</label>
                <select name="category_id" class="w-full rounded-lg border-slate-300">
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}" @selected($product->category_id == $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Nama</label>
                <input name="name" value="{{ old('name', $product->name) }}" class="w-full rounded-lg border-slate-300">
            </div>
            <div>
                <label class="block text-sm mb-1">Satuan</label>
                <input name="unit" value="{{ old('unit', $product->unit) }}" class="w-full rounded-lg border-slate-300">
            </div>
            <div>
                <label class="block text-sm mb-1">Harga Beli</label>
                <input type="number" step="0.01" name="purchase_price" value="{{ $product->purchase_price }}"
                    class="w-full rounded-lg border-slate-300">
            </div>
            <div>
                <label class="block text-sm mb-1">Harga Jual</label>
                <input type="number" step="0.01" name="selling_price" value="{{ $product->selling_price }}"
                    class="w-full rounded-lg border-slate-300">
            </div>
            <div>
                <label class="block text-sm mb-1">Min Stock</label>
                <input type="number" name="min_stock" value="{{ $product->min_stock }}"
                    class="w-full rounded-lg border-slate-300">
            </div>
            <div>
                <label class="block text-sm mb-1">Max Stock</label>
                <input type="number" name="max_stock" value="{{ $product->max_stock }}"
                    class="w-full rounded-lg border-slate-300">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border-slate-300">{{ $product->description }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Gambar (opsional)</label>
                <input type="file" name="image" class="rounded-lg border-slate-300">
                @if ($product->image_path)
                    <div class="mt-2 text-sm text-slate-500">Gambar saat ini: {{ $product->image_path }}</div>
                @endif
            </div>
            <div class="md:col-span-2 flex gap-3">
                <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white">Update</button>
                <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-lg border">Kembali</a>
            </div>
        </form>
    </div>
@endsection
