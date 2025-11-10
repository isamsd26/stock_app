@extends('layouts.base')
@section('content')
    @include('partials.page', ['title' => 'Laporan Penyesuaian'])

    <div class="bg-white rounded-2xl shadow p-6">
        <ul class="text-sm divide-y">
            @foreach ($adjs as $a)
                <li class="py-2 flex justify-between">
                    <span>{{ $a->date->format('d/m/Y') }} • {{ $a->product->name }} • {{ strtoupper($a->type) }} •
                        {{ $a->reason }}</span>
                    <span class="font-medium {{ $a->type === 'increase' ? 'text-emerald-700' : 'text-rose-700' }}">
                        {{ $a->type === 'increase' ? '+' : '-' }}{{ $a->quantity }}
                    </span>
                </li>
            @endforeach
        </ul>
        <div class="mt-3">{{ $adjs->links() }}</div>
    </div>
@endsection
