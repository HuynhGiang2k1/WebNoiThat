<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'email',
        'tel',
        'address',
        'product_id',
        'money',
        'send_memo',
        'shipping_fee',
        'verified_at',
        'order_status',
        'cart_id'
    ];

    public function pay()
    {
        return $this->hasOne(Pay::class);
    }
}
