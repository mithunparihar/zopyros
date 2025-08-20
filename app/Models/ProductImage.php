<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = ['is_publish'];

    public function scopeProduct($query, $productId)
    {
        return $query->whereProductId($productId);
    }

    public function scopeColor($query, $colorId)
    {
        return $query->whereColorId($colorId);
    }
}
