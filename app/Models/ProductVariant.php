<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = ['is_publish'];

    protected function sku(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
        );
    }

    protected function mrp(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
            get: fn($value) => round($value)
        );
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
            get: fn($value) => round($value)
        );
    }

    protected function stock(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
        );
    }


    public function colorInfo()
    {
        return $this->hasOne(ProductColor::class, 'id', 'color_id');
    }

    public function variantInfo()
    {
        return $this->hasOne(CategoryVariant::class, 'id', 'variant_id');
    }
}
