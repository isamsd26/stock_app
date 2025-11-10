@if (session('success'))
    <div
        class="mb-4 rounded-xl border border-emerald-300/50 bg-emerald-100/60 px-4 py-3 text-emerald-900 dark:bg-emerald-900/30 dark:text-emerald-100 dark:border-emerald-700/50">
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div
        class="mb-4 rounded-xl border border-rose-300/50 bg-rose-100/60 px-4 py-3 text-rose-900 dark:bg-rose-900/30 dark:text-rose-100 dark:border-rose-700/50">
        <div class="font-semibold mb-1">Terjadi kesalahan:</div>
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif
