@extends('layouts.base')
@section('content')
    @include('partials.page', ['title' => 'Transaksi Stok'])

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Barang Masuk --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-semibold mb-4">Barang Masuk</h3>
            <form method="post" action="{{ route('stock.in.store') }}" class="space-y-3">
                @csrf
                <select name="product_id" class="w-full rounded-lg border-slate-300">
                    @foreach ($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
                <select name="supplier_id" class="w-full rounded-lg border-slate-300">
                    <option value="">(tanpa supplier)</option>
                    @foreach ($suppliers as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
                <input type="number" name="quantity" min="1" placeholder="Qty"
                    class="w-full rounded-lg border-slate-300">
                <input type="date" name="date" value="{{ now()->toDateString() }}"
                    class="w-full rounded-lg border-slate-300">
                <input type="text" name="notes" placeholder="Catatan" class="w-full rounded-lg border-slate-300">
                <button class="w-full px-4 py-2 rounded-lg bg-emerald-600 text-white">Tambahkan</button>
            </form>
        </div>

        {{-- Barang Keluar --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-semibold mb-4">Barang Keluar</h3>
            <form method="post" action="{{ route('stock.out.store') }}" class="space-y-3">
                @csrf
                <select name="product_id" class="w-full rounded-lg border-slate-300">
                    @foreach ($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
                <input type="number" name="quantity" min="1" placeholder="Qty"
                    class="w-full rounded-lg border-slate-300">
                <input type="date" name="date" value="{{ now()->toDateString() }}"
                    class="w-full rounded-lg border-slate-300">
                <input type="text" name="destination" placeholder="Tujuan" class="w-full rounded-lg border-slate-300">
                <input type="text" name="notes" placeholder="Catatan" class="w-full rounded-lg border-slate-300">
                <button class="w-full px-4 py-2 rounded-lg bg-indigo-600 text-white">Tambahkan</button>
            </form>
        </div>

        {{-- Penyesuaian --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-semibold mb-4">Penyesuaian</h3>
            <form method="post" action="{{ route('stock.adjust.store') }}" class="space-y-3">
                @csrf
                <select name="product_id" class="w-full rounded-lg border-slate-300">
                    @foreach ($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
                <select name="type" class="w-full rounded-lg border-slate-300">
                    <option value="increase">Tambah</option>
                    <option value="decrease">Kurang</option>
                </select>
                <input type="number" name="quantity" min="1" placeholder="Qty"
                    class="w-full rounded-lg border-slate-300">
                <input type="date" name="date" value="{{ now()->toDateString() }}"
                    class="w-full rounded-lg border-slate-300">
                <input type="text" name="reason" placeholder="Alasan" class="w-full rounded-lg border-slate-300">
                <button class="w-full px-4 py-2 rounded-lg bg-slate-900 text-white">Sesuaikan</button>
            </form>
        </div>
    </div>

    {{-- Riwayat --}}
    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow p-6">
            <h4 class="font-semibold mb-3">Riwayat Masuk</h4>
            <ul class="space-y-2 text-sm">
                @foreach ($ins as $i)
                    <li class="flex justify-between border-b py-2">
                        <span>{{ $i->date->format('d/m/Y') }} • {{ $i->product->name }}</span>
                        <span class="font-medium text-emerald-700">+{{ $i->quantity }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-3">{{ $ins->links() }}</div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h4 class="font-semibold mb-3">Riwayat Keluar</h4>
            <ul class="space-y-2 text-sm">
                @foreach ($outs as $o)
                    <li class="flex justify-between border-b py-2">
                        <span>{{ $o->date->format('d/m/Y') }} • {{ $o->product->name }}</span>
                        <span class="font-medium text-rose-700">-{{ $o->quantity }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-3">{{ $outs->links() }}</div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h4 class="font-semibold mb-3">Riwayat Penyesuaian</h4>
            <ul class="space-y-2 text-sm">
                @foreach ($adjs as $a)
                    <li class="flex justify-between border-b py-2">
                        <span>{{ $a->date->format('d/m/Y') }} • {{ $a->product->name }} •
                            {{ strtoupper($a->type) }}</span>
                        <span class="font-medium {{ $a->type === 'increase' ? 'text-emerald-700' : 'text-rose-700' }}">
                            {{ $a->type === 'increase' ? '+' : '-' }}{{ $a->quantity }}
                        </span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-3">{{ $adjs->links() }}</div>
        </div>
    </div>
@endsection
