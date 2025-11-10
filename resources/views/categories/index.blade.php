@extends('layouts.base')
@section('content')
    @include('partials.page', [
        'title' => 'Kategori',
        'actions' => [['href' => route('categories.create'), 'label' => '+ Tambah']],
    ])

    <div class="bg-white rounded-2xl shadow p-6">
        <form method="get" class="mb-4 flex gap-3">
            <input name="s" value="{{ request('s') }}" placeholder="Cari nama kategori..."
                class="w-full md:w-1/3 rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            <button class="px-4 py-2 rounded-lg bg-slate-900 text-white">Filter</button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-black">
                    <tr>
                        <th class="py-2 ">Nama</th>
                        <th class="py-2">Status</th>
                        <th class="py-2 w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($categories as $c)
                        <tr>
                            <td class="py-2 text-black">{{ $c->name }}</td>
                            <td class="py-2">
                                @if ($c->active)
                                    <span class="px-2 py-1 text-xs rounded bg-emerald-100 text-emerald-700">Aktif</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded bg-slate-100 text-slate-600">Nonaktif</span>
                                @endif
                            </td>
                            <td class="py-2">
                                <a href="{{ route('categories.edit', $c) }}" class="text-indigo-600 hover:underline">Edit</a>
                                <form action="{{ route('categories.destroy', $c) }}" method="post" class="inline"
                                    onsubmit="return confirm('Hapus kategori?')">
                                    @csrf @method('DELETE')
                                    <button class="text-rose-600 hover:underline ml-3">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $categories->links() }}</div>
    </div>
@endsection
