<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Support\CodeGenerator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = Product::with('category');

        if ($request->filled('category_id')) $q->where('category_id', $request->category_id);
        if ($s = $request->get('s')) {
            $q->where(function ($w) use ($s) {
                $w->where('name', 'like', "%$s%")
                    ->orWhere('product_code', 'like', "%$s%");
            });
        }

        $products = $q->orderBy('name')->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();
        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'    => ['required', 'exists:categories,id'],
            'name'           => ['required', 'string', 'max:200'],
            'description'    => ['nullable', 'string'],
            'unit'           => ['required', 'string', 'max:20'],
            'min_stock'      => ['nullable', 'integer', 'min:0'],
            'max_stock'      => ['nullable', 'integer', 'gte:min_stock'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'selling_price'  => ['nullable', 'numeric', 'min:0'],
            'image'          => ['nullable', 'image', 'max:2048'],
        ]);

        $data['product_code'] = CodeGenerator::nextProductCode();
        $data['stock'] = 0;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Produk dibuat');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id'    => ['required', 'exists:categories,id'],
            'name'           => ['required', 'string', 'max:200'],
            'description'    => ['nullable', 'string'],
            'unit'           => ['required', 'string', 'max:20'],
            'min_stock'      => ['nullable', 'integer', 'min:0'],
            'max_stock'      => ['nullable', 'integer', 'gte:min_stock'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'selling_price'  => ['nullable', 'numeric', 'min:0'],
            'image'          => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path) Storage::disk('public')->delete($product->image_path);
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Produk diupdate');
    }

    public function destroy(Product $product)
    {
        if ($product->image_path) Storage::disk('public')->delete($product->image_path);
        $product->delete();
        return back()->with('success', 'Produk dihapus');
    }
}
