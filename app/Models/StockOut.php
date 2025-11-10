<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockOut extends Model
{
    use HasFactory;

    protected $table = 'stock_out';

    protected $fillable = [
        'product_id',
        'destination',
        'quantity',
        'date',
        'reference_no',
        'notes',
        'created_by'
    ];

    protected $casts = ['date' => 'date', 'quantity' => 'integer'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
