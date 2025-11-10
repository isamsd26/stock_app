<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\StockAdjustment;
use App\Models\Supplier;
use App\Services\StockService;
use App\Support\CodeGenerator;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function history(Request $request)
    {
        $from = $request->get('from');
        $to   = $request->get('to');
        $productId = $request->get('product_id');

        $ins = StockIn::with('product')->when($from, fn($q) => $q->whereDate('date', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('date', '<=', $to))
            ->when($productId, fn($q) => $q->where('product_id', $productId));

        $outs = StockOut::with('product')->when($from, fn($q) => $q->whereDate('date', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('date', '<=', $to))
            ->when($productId, fn($q) => $q->where('product_id', $productId));

        $adjs = StockAdjustment::with('product')->when($from, fn($q) => $q->whereDate('date', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('date', '<=', $to))
            ->when($productId, fn($q) => $q->where('product_id', $productId));

        // Untuk tampilan sederhana, kirim terpisah
        $products = Product::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('transactions.history', [
            'ins' => $ins->latest('date')->paginate(10)->withQueryString(),
            'outs' => $outs->latest('date')->paginate(10, ['*'], 'outs')->withQueryString(),
            'adjs' => $adjs->latest('date')->paginate(10, ['*'], 'adjs')->withQueryString(),
            'products' => $products,
            'suppliers' => $suppliers,
        ]);
    }

    public function storeIn(Request $request, StockService $svc)
    {
        $data = $request->validate([
            'product_id'  => ['required', 'exists:products,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'quantity'    => ['required', 'integer', 'min:1'],
            'date'        => ['required', 'date'],
            'notes'       => ['nullable', 'string'],
        ]);
        $product = Product::findOrFail($data['product_id']);
        $in = $svc->receive($product, (int)$data['quantity'], [
            'supplier_id'  => $data['supplier_id'] ?? null,
            'date'         => $data['date'],
            'reference_no' => CodeGenerator::next('PO', 'stock_in'),
            'notes'        => $data['notes'] ?? null,
        ]);
        return back()->with('success', "Barang masuk #{$in->reference_no} tersimpan");
    }

    public function storeOut(Request $request, StockService $svc)
    {
        $data = $request->validate([
            'product_id'  => ['required', 'exists:products,id'],
            'quantity'    => ['required', 'integer', 'min:1'],
            'date'        => ['required', 'date'],
            'destination' => ['nullable', 'string', 'max:255'],
            'notes'       => ['nullable', 'string'],
        ]);
        $product = Product::findOrFail($data['product_id']);
        $out = $svc->issue($product, (int)$data['quantity'], [
            'date'         => $data['date'],
            'destination'  => $data['destination'] ?? null,
            'reference_no' => CodeGenerator::next('DO', 'stock_out'),
            'notes'        => $data['notes'] ?? null,
        ]);
        return back()->with('success', "Barang keluar #{$out->reference_no} tersimpan");
    }

    public function storeAdjust(Request $request, StockService $svc)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type'       => ['required', 'in:increase,decrease'],
            'quantity'   => ['required', 'integer', 'min:1'],
            'date'       => ['required', 'date'],
            'reason'     => ['nullable', 'string', 'max:255'],
        ]);
        $product = Product::findOrFail($data['product_id']);
        $adj = $svc->adjust($product, $data['type'], (int)$data['quantity'], [
            'date'   => $data['date'],
            'reason' => $data['reason'] ?? null,
        ]);
        return back()->with('success', "Penyesuaian stok #{$adj->id} tersimpan");
    }
}
