<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'price',
        'quantity',
        'name',
        'address',
        'phone',
        'payment_method',
        'payment_status',
        'order_status',
    ];
    public function user(){
        return $this->belongsTo(User::class );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
