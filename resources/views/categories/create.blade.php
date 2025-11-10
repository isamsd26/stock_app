@extends('layouts.base')
@section('content')
    @include('partials.page', ['title' => 'Tambah Kategori'])

    <div class="bg-white rounded-2xl shadow p-6 max-w-xl text-black">
        <form method="post" action="{{ route('categories.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm mb-1">Nama</label>
                <input name="name" required
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm mb-1">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="active" value="1" checked class="rounded border-slate-300">
                <span>Aktif</span>
            </div>
            <div class="flex gap-3">
                <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white">Simpan</button>
                <a href="{{ route('categories.index') }}" class="px-4 py-2 rounded-lg border">Batal</a>
            </div>
        </form>
    </div>
@endsection
