<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_en',
        'category_id'
    ];

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
