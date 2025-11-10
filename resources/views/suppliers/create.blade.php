@extends('layouts.base')
@section('content')
    @include('partials.page', ['title' => 'Tambah Supplier'])

    <div class="bg-white rounded-2xl shadow p-6 max-w-xl text-black">
        <form method="post" action="{{ route('suppliers.store') }}" class="space-y-4">
            @csrf
            <div><label class="block text-sm mb-1">Nama</label><input name="name" required
                    class="w-full rounded-lg border-slate-300"></div>
            <div><label class="block text-sm mb-1">Kontak</label><input name="contact"
                    class="w-full rounded-lg border-slate-300"></div>
            <div><label class="block text-sm mb-1">Alamat</label>
                <textarea name="address" rows="3" class="w-full rounded-lg border-slate-300"></textarea>
            </div>
            <div class="flex gap-3">
                <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white">Simpan</button>
                <a class="px-4 py-2 rounded-lg border" href="{{ route('suppliers.index') }}">Batal</a>
            </div>
        </form>
    </div>
@endsection
