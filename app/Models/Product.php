<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'imgPath',
        'nutritional_id',
        'composition',
        'price'
    ];

    public function nutritional(): belongsTo
    {
        return $this->belongsTo(Nutritional::class);
    }
}
