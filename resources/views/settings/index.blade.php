@extends('layouts.base')
@section('content')
    @include('partials.page', ['title' => 'Pengaturan Perusahaan'])

    <div class="bg-white rounded-2xl shadow p-6 max-w-3xl">
        <form method="post" action="{{ route('settings.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <div>
                <label class="block text-sm mb-1">Nama Perusahaan</label>
                <input name="company_name" value="{{ old('company_name', $setting->company_name ?? '') }}"
                    class="w-full rounded-lg border-slate-300">
            </div>
            <div>
                <label class="block text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $setting->email ?? '') }}"
                    class="w-full rounded-lg border-slate-300">
            </div>
            <div>
                <label class="block text-sm mb-1">Telepon</label>
                <input name="phone" value="{{ old('phone', $setting->phone ?? '') }}"
                    class="w-full rounded-lg border-slate-300">
            </div>
            <div>
                <label class="block text-sm mb-1">Pajak (%)</label>
                <input type="number" step="0.01" name="tax_rate" value="{{ old('tax_rate', $setting->tax_rate ?? 0) }}"
                    class="w-full rounded-lg border-slate-300">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Alamat</label>
                <textarea name="address" rows="3" class="w-full rounded-lg border-slate-300">{{ old('address', $setting->address ?? '') }}</textarea>
            </div>
            <div class="md:col-span-2 flex gap-3">
                <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white">Simpan</button>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg border">Batal</a>
            </div>
        </form>
    </div>
@endsection
