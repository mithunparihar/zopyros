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
        return $this->hasMany(ProductVariant::class)->orderBy('price', 'DESC');
    }

    public function scopeActive($query)
    {
        return $query->whereIsPublish(1);
    }

    public function scopeRelated($query, Product $product)
    {
        $categories = $product->categories()->whereHas('categoryInfo', function ($qert) {
            $qert->active();
        })->pluck('category_id')->toArray();

        $varianttypes = $product->lowestPrice()->whereHas('variantTypeInfo', function ($qert) {
            $qert->active();
        })->pluck('title')->toArray();

        $variants = $product->lowestPrice()->whereHas('variantInfo', function ($qert) {
            $qert->active();
        })->pluck('variant_id')->toArray();

        return $query->where('id', '!=', $product->id)
            ->whereHas('categories', function ($qwert) use ($categories) {
                $qwert->whereIn('category_id', $categories);
            })
            ->whereHas('lowestPrice', function ($qwert) use ($varianttypes,$variants) {
                $qwert->whereIn('title', $varianttypes);
                // $qwert->whereIn('variant_id', $variants);
            })
            ->limit(10);
    }

    public function scopeSearch($query, $search = null)
    {
        if ($search) {
            $words      = explode(" ", $search);
            $totalWords = count($words);
            $results    = [];

            for ($length = $totalWords; $length >= 1; $length--) {
                for ($i = 0; $i <= $totalWords - $length; $i++) {
                    $slice     = array_slice($words, $i, $length);
                    $results[] = implode(" ", $slice);
                }
            }

            $query->where(function ($qry) use ($results) {

                foreach ($results as $phrase) {
                    $qry->orWhere('title', 'LIKE', '%' . $phrase . '%');
                }
            });
        }

        if (request('variant_type')) {
            $query->whereHas('lowestPrice', function ($qert) {
                $qert->whereIn('title', request('variant_type', []));
            });
        }
        switch (request('sort')) {
            case 'a-z':
                $query->orderBy('title');
                break;
            case 'z-a':
                $query->orderBy('title', 'DESC');
                break;
            case 'newest':
                $query->orderBy('id', 'DESC');
                break;
            default:
                $query->orderBy('id', 'DESC');
                break;
        }

        return $query;
    }
}
