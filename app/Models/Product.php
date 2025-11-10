<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'product_code',
        'name',
        'description',
        'unit',
        'stock',
        'min_stock',
        'max_stock',
        'purchase_price',
        'selling_price',
        'image_path'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price'  => 'decimal:2',
        'stock'          => 'integer',
        'min_stock'      => 'integer',
        'max_stock'      => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function stockIns()
    {
        return $this->hasMany(StockIn::class);
    }
    public function stockOuts()
    {
        return $this->hasMany(StockOut::class);
    }
    public function adjustments()
    {
        return $this->hasMany(StockAdjustment::class);
    }
}
