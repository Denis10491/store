<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsInOrders extends Model
{
    use HasFactory;

    protected $table = 'products_in_orders';

    protected $fillable = [
        'order_id',
        'product_id',
        'count'
    ];
}
