<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Category::firstOrCreate(['name' => 'Umum'], ['active' => true]);
        Product::firstOrCreate(
            ['product_code' => 'PRD0001'],
            [
                'category_id' => $cat->id,
                'name' => 'Contoh Barang',
                'unit' => 'pcs',
                'stock' => 10,
                'min_stock' => 5,
                'purchase_price' => 10000,
                'selling_price' => 15000
            ]
        );
    }
}
