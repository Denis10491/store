<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Nutritional extends Model
{
    use HasFactory;

    protected $table = 'nutritional';

    protected $fillable = [
        'proteins',
        'fats',
        'carbohydrates',
        'text'
    ];

    public function product() {
        return $this->hasOne(Product::class);
    }
}
