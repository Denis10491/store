<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'imgPath',
        'nutritional_id',
        'composition',
        'price'
    ];

    public function nutritional(): BelongsTo
    {
        return $this->belongsTo(Nutritional::class);
    }

    public function products_on_orders(): HasMany
    {
        return $this->hasMany(ProductsInOrders::class);
    }
}