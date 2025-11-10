<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function stock(Request $request)
    {
        $q = Product::with('category');
        if ($request->filled('category_id')) $q->where('category_id', $request->category_id);
        if ($s = $request->get('s')) $q->where('name', 'like', "%$s%");
        $rows = $q->orderBy('name')->paginate(25)->withQueryString();

        $total_qty = Product::sum('stock');
        $total_value = Product::select(DB::raw('SUM(stock * purchase_price) as v'))->value('v');

        return view('reports.stock', compact('rows', 'total_qty', 'total_value'));
    }

    public function movement(Request $request)
    {
        $from = $request->get('from');
        $to   = $request->get('to');

        $ins  = StockIn::with('product')->when($from, fn($q) => $q->whereDate('date', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('date', '<=', $to))
            ->orderBy('date', 'desc')->paginate(20)->withQueryString();

        $outs = StockOut::with('product')->when($from, fn($q) => $q->whereDate('date', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('date', '<=', $to))
            ->orderBy('date', 'desc')->paginate(20, ['*'], 'outs')->withQueryString();

        return view('reports.movement', compact('ins', 'outs'));
    }

    public function adjustments(Request $request)
    {
        $from = $request->get('from');
        $to   = $request->get('to');

        $adjs = StockAdjustment::with('product')->when($from, fn($q) => $q->whereDate('date', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('date', '<=', $to))
            ->orderBy('date', 'desc')->paginate(25)->withQueryString();

        return view('reports.adjustments', compact('adjs'));
    }
}
