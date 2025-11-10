@extends('layouts.base')
@section('content')
    @include('partials.page', ['title' => 'Laporan Mutasi'])

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow p-6">
            <h4 class="font-semibold mb-3">Masuk</h4>
            <ul class="text-sm divide-y">
                @foreach ($ins as $i)
                    <li class="py-2 flex justify-between">
                        <span>{{ $i->date->format('d/m/Y') }} • {{ $i->product->name }}</span>
                        <span class="font-medium text-emerald-700">+{{ $i->quantity }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-3">{{ $ins->links() }}</div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h4 class="font-semibold mb-3">Keluar</h4>
            <ul class="text-sm divide-y">
                @foreach ($outs as $o)
                    <li class="py-2 flex justify-between">
                        <span>{{ $o->date->format('d/m/Y') }} • {{ $o->product->name }}</span>
                        <span class="font-medium text-rose-700">-{{ $o->quantity }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-3">{{ $outs->links() }}</div>
        </div>
    </div>
@endsection
