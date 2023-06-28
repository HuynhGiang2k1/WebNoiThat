<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'money',
        'vnpay_code',
        'vnp_bank_code',
        'vnp_TransactionNo',
        'vnp_TmnCode',
        'status',
    ];
}
