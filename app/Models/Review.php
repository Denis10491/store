<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'body',
        'rating'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function product(): belongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
