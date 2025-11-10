@extends('layouts.base')
@section('content')
    @include('partials.page', ['title' => 'Edit Kategori'])

    <div class="bg-white rounded-2xl shadow p-6 max-w-xl text-black">
        <form method="post" action="{{ route('categories.update', $category) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm mb-1 ">Nama</label>
                <input name="name" value="{{ old('name', $category->name) }}" required
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm mb-1">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $category->description) }}</textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="active" value="1" {{ $category->active ? 'checked' : '' }}
                    class="rounded border-slate-300">
                <span>Aktif</span>
            </div>
            <div class="flex gap-3">
                <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white">Update</button>
                <a href="{{ route('categories.index') }}" class="px-4 py-2 rounded-lg border">Kembali</a>
            </div>
        </form>
    </div>
@endsection
