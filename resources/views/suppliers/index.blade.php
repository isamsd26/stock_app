@extends('layouts.base')
@section('content')
    @include('partials.page', [
        'title' => 'Supplier',
        'actions' => [['href' => route('suppliers.create'), 'label' => '+ Tambah']],
    ])

    <div class="bg-white rounded-2xl shadow p-6">
        <form method="get" class="mb-4 flex gap-3">
            <input name="s" value="{{ request('s') }}" placeholder="Cari nama..."
                class="w-full md:w-1/3 rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            <button class="px-4 py-2 rounded-lg bg-slate-900 text-white">Filter</button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-slate-500">
                    <tr>
                        <th class="py-2">Nama</th>
                        <th class="py-2">Kontak</th>
                        <th class="py-2">Alamat</th>
                        <th class="py-2 w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($suppliers as $s)
                        <tr>
                            <td class="py-2">{{ $s->name }}</td>
                            <td class="py-2">{{ $s->contact }}</td>
                            <td class="py-2">{{ $s->address }}</td>
                            <td class="py-2">
                                <a href="{{ route('suppliers.edit', $s) }}" class="text-indigo-600 hover:underline">Edit</a>
                                <form action="{{ route('suppliers.destroy', $s) }}" method="post" class="inline"
                                    onsubmit="return confirm('Hapus supplier?')">
                                    @csrf @method('DELETE')
                                    <button class="text-rose-600 hover:underline ml-3">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $suppliers->links() }}</div>
    </div>
@endsection
