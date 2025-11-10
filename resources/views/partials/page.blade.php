{{-- @include('partials.page', ['title'=>'Produk', 'actions'=>[ ['href'=>route('products.create'),'label'=>'+ Tambah'] ]]) --}}
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-semibold">{{ $title ?? '' }}</h1>
    @if (!empty($actions))
        <div class="flex gap-2">
            @foreach ($actions as $a)
                <a href="{{ $a['href'] }}"
                    class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 text-sm">
                    {{ $a['label'] }}
                </a>
            @endforeach
        </div>
    @endif
</div>
