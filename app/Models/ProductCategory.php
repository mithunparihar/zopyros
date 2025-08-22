<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = ['is_publish'];

    public function categoryInfo()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function productInfo()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    function scopeCategory($query,$category){
        return $query->whereCategoryId($category);
    }
}
