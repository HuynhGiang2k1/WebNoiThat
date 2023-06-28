<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'size',
        'cover',
        'quantity',
        'description',
    ];

    public function images()
    {
        return $this->hasMany(Image::class, 'product_id');
    }

    public function categories()
    {
        return $this->morphedByMany(Category::class, 'productable');
    }

    public function subcategories()
    {
        return $this->morphedByMany(SubCategory::class, 'productable');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
