<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Nutritional extends Model
{
    use HasFactory;

    protected $fillable = [
        'proteins',
        'fats',
        'carbohydrates'
    ];

    public function product(): hasOne {
        return $this->hasOne(Product::class);
    }
}
