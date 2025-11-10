<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('settings.index', compact('setting'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_name' => ['nullable', 'string', 'max:150'],
            'address'      => ['nullable', 'string'],
            'phone'        => ['nullable', 'string', 'max:50'],
            'email'        => ['nullable', 'email'],
            'tax_rate'     => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);
        $setting = Setting::first();
        $setting ? $setting->update($data) : Setting::create($data);
        return back()->with('success', 'Pengaturan disimpan');
    }
}
