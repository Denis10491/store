<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Traits\HasOrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory, HasOrderStatus;

    protected $fillable = [
        'address',
        'status'
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'created_at' => 'datetime'
    ];

    public function products(): belongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_products')->withPivot('count');
    }
}
