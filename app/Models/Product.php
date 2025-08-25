<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use RecentlyViewed\Models\Contracts\Viewable;
use RecentlyViewed\Models\Traits\CanBeViewed;

class Product extends Model implements Viewable
{
    use CanBeViewed;
    use HasFactory, SoftDeletes;
    public $fillable = ['is_publish'];

    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
        );
    }
    protected function alias(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtolower(Str::slug($value)),
            get: fn($value) => strtolower(Str::slug($value))
        );
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            set: fn($value) => \Content::purifierClean(Str::squish($value)),
        );
    }

    protected function specifications(): Attribute
    {
        return Attribute::make(
            set: fn($value) => \Content::purifierClean(Str::squish($value)),
        );
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function categories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('is_primary', 'DESC');
    }

    public function lowestPrice()
    {
        return $this->hasMany(ProductVariant::class)->orderBy('price');
    }

    public function maxPrice()
    {
        return $this->hasMany(ProductVariant::class)->orderBy('price','DESC');
    }

    public function scopeActive($query)
    {
        return $query->whereIsPublish(1);
    }

    public function scopeRelated($query, Product $product)
    {
        return $query->where('id', '!=', $product->id)
            ->limit(10);
    }

    public function scopeSearch($query, $search)
    {
        $words      = explode(" ", $search);
        $totalWords = count($words);
        $results    = [];

        for ($length = $totalWords; $length >= 1; $length--) {
            for ($i = 0; $i <= $totalWords - $length; $i++) {
                $slice     = array_slice($words, $i, $length);
                $results[] = implode(" ", $slice);
            }
        }

        return $query->where(function ($qry) use ($results) {

            foreach ($results as $phrase) {
                $qry->orWhere('title', 'LIKE', '%' . $phrase . '%');
            }
        });
    }
}
