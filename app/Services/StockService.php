<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\StockAdjustment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockService
{
    public function receive(Product $product, int $qty, array $data): StockIn
    {
        return DB::transaction(function () use ($product, $qty, $data) {
            if ($qty <= 0) throw ValidationException::withMessages(['quantity' => 'Harus > 0']);
            $in = StockIn::create([
                'product_id'   => $product->id,
                'supplier_id'  => $data['supplier_id'] ?? null,
                'quantity'     => $qty,
                'date'         => $data['date'],
                'reference_no' => $data['reference_no'],
                'notes'        => $data['notes'] ?? null,
                'created_by'   => Auth::id(),
            ]);
            $product->increment('stock', $qty);
            return $in;
        });
    }

    public function issue(Product $product, int $qty, array $data): StockOut
    {
        return DB::transaction(function () use ($product, $qty, $data) {
            if ($qty <= 0) throw ValidationException::withMessages(['quantity' => 'Harus > 0']);
            if ($product->stock < $qty) {
                throw ValidationException::withMessages(['quantity' => 'Stok tidak cukup']);
            }
            $out = StockOut::create([
                'product_id'   => $product->id,
                'destination'  => $data['destination'] ?? null,
                'quantity'     => $qty,
                'date'         => $data['date'],
                'reference_no' => $data['reference_no'],
                'notes'        => $data['notes'] ?? null,
                'created_by'   => Auth::id(),
            ]);
            $product->decrement('stock', $qty);
            return $out;
        });
    }

    public function adjust(Product $product, string $type, int $qty, array $data): StockAdjustment
    {
        return DB::transaction(function () use ($product, $type, $qty, $data) {
            if (!in_array($type, ['increase', 'decrease'])) throw new \InvalidArgumentException('type invalid');
            if ($qty <= 0) throw ValidationException::withMessages(['quantity' => 'Harus > 0']);
            if ($type === 'decrease' && $product->stock < $qty) {
                throw ValidationException::withMessages(['quantity' => 'Stok tidak cukup untuk penyesuaian turun']);
            }
            $adj = StockAdjustment::create([
                'product_id' => $product->id,
                'type'       => $type,
                'quantity'   => $qty,
                'reason'     => $data['reason'] ?? null,
                'date'       => $data['date'],
                'created_by' => Auth::id(),
            ]);
            $type === 'increase' ? $product->increment('stock', $qty) : $product->decrement('stock', $qty);
            return $adj;
        });
    }
}
