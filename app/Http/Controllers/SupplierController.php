<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $q = Supplier::query();
        if ($s = $request->get('s')) {
            $q->where('name', 'like', "%$s%");
        }
        $suppliers = $q->orderBy('name')->paginate(15)->withQueryString();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'contact' => ['nullable', 'string', 'max:150'],
            'address' => ['nullable', 'string'],
        ]);
        Supplier::create($data);
        return redirect()->route('suppliers.index')->with('success', 'Supplier dibuat');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'contact' => ['nullable', 'string', 'max:150'],
            'address' => ['nullable', 'string'],
        ]);
        $supplier->update($data);
        return redirect()->route('suppliers.index')->with('success', 'Supplier diupdate');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return back()->with('success', 'Supplier dihapus');
    }
}
