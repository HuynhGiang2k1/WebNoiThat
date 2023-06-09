<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_percent',
        'val',
        'term_start',
        'term_end',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
