@extends('layouts.base')
@section('content')
    @include('partials.page', ['title' => 'Edit Supplier'])

    <div class="bg-white rounded-2xl shadow p-6 max-w-xl text-black">
        <form method="post" action="{{ route('suppliers.update', $supplier) }}" class="space-y-4">
            @csrf @method('PUT')
            <div><label class="block text-sm mb-1">Nama</label><input name="name" value="{{ $supplier->name }}"
                    class="w-full rounded-lg border-slate-300"></div>
            <div><label class="block text-sm mb-1">Kontak</label><input name="contact" value="{{ $supplier->contact }}"
                    class="w-full rounded-lg border-slate-300"></div>
            <div><label class="block text-sm mb-1">Alamat</label>
                <textarea name="address" rows="3" class="w-full rounded-lg border-slate-300">{{ $supplier->address }}</textarea>
            </div>
            <div class="flex gap-3">
                <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white">Update</button>
                <a class="px-4 py-2 rounded-lg border" href="{{ route('suppliers.index') }}">Kembali</a>
            </div>
        </form>
    </div>
@endsection
