<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CategoryVariant extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = ['is_publish'];

    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value)
        );
    }

    public function variantInfo()
    {
        return $this->hasOne(Variant::class, 'id', 'variant_id');
    }

    public function categoryInfo()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->whereIsPublish(1);
    }

    public function scopeCategory($query,$category)
    {
        return $query->whereCategoryId($category);
    }
}
