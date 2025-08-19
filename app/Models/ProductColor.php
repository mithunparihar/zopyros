<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProductColor extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = ['is_publish'];

    protected function code(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
        );
    }

    protected function hex(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
        );
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'color_id', 'id')->orderBy('is_primary', 'DESC');
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'color_id', 'id');
    }
}
