@extends('layouts.base')
@section('content')
    @include('partials.page', ['title' => 'Laporan Stok'])

    <div class="bg-white rounded-2xl shadow p-6">
        <p class="text-sm text-slate-500 mb-4">
            Total Qty: <b>{{ number_format($total_qty) }}</b> •
            Nilai Persediaan: <b>Rp {{ number_format($total_value, 0, ',', '.') }}</b>
        </p>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-slate-500">
                    <tr>
                        <th class="py-2">Kode</th>
                        <th class="py-2">Nama</th>
                        <th class="py-2">Kategori</th>
                        <th class="py-2 text-right">Stok</th>
                        <th class="py-2 text-right">Harga Beli</th>
                        <th class="py-2 text-right">Nilai</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($rows as $r)
                        <tr>
                            <td class="py-2">{{ $r->product_code }}</td>
                            <td class="py-2">{{ $r->name }}</td>
                            <td class="py-2">{{ $r->category->name ?? '-' }}</td>
                            <td class="py-2 text-right">{{ $r->stock }}</td>
                            <td class="py-2 text-right">{{ number_format($r->purchase_price, 0, ',', '.') }}</td>
                            <td class="py-2 text-right">{{ number_format($r->stock * $r->purchase_price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $rows->links() }}</div>
    </div>
@endsection
