<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'count'
    ];

    public function orders(): HasOne
    {
        return $this->HasOne(Order::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'id');
    }
}
