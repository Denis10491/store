<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'imgPath',
        'nutritional_id',
        'composition',
        'price',
        'amount'
    ];

    public function nutritional(): belongsTo
    {
        return $this->belongsTo(Nutritional::class);
    }
    
    public function reviews(): hasMany
    {
        return $this->hasMany(Review::class);
    }
}
