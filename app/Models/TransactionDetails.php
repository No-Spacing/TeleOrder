<?php

namespace App\Models;

use App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TransactionDetails extends Model
{
    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'unit_price',
        'net_amount',
    ];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
