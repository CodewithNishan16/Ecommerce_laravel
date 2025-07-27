<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'discounted_price',
        'photopath',
        'category_id',
        'stock'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

  
}
