<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = ['is_publish', 'is_home', 'is_featured', 'is_menu', 'is_footer'];
    protected $casts = [
        'materials' => 'array',
    ];

    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
            // get:fn($value)=>ucwords(Str::squish($value))
        );
    }
    protected function alias(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtolower(Str::slug($value)),
            get: fn($value) => strtolower(Str::slug($value))
        );
    }
    protected function shortDescription(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
            // get:fn($value)=>ucwords(Str::squish($value))
        );
    }
    protected function customizedPrice(): Attribute
    {
        return Attribute::make(
            // set:fn($value)=>strtolower(Str::squish($value)),
            get: fn($value) => number_format(round($value))
        );
    }

    public function getSegments()
    {

        if ($this->parentInfo) {
            return array_merge($this->parentInfo->getSegments(), [$this->alias]);
        } else {
            return [$this->alias];
        }
    }

    public function fullURL()
    {
        return implode('/', $this->getSegments());
    }

    public function faqs()
    {
        return $this->hasMany(CategoryFaq::class, 'category_id', 'id');
    }
    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function parentInfo()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function variants()
    {
        return $this->hasMany(CategoryVariant::class,'category_id','id');
    }

    public function scopeActive($query)
    {
        return $query->whereIsPublish(1)->sequence();
    }

    public function scopeHome($query)
    {
        return $query->whereIsHome(1);
    }
    public function scopeFooter($query)
    {
        return $query->whereIsFooter(1);
    }
    public function scopeParent($query, $parentId = 0)
    {
        return $query->whereParentId($parentId ?? 0);
    }
    public function scopeSequence($query)
    {
        return $query->orderBy('sequence');
    }
    public function scopeActiveParent($query)
    {
        return $query->whereHas('parentInfo', function ($qry) {
            return $qry->active();
        })->orWhereDoesntHave('parentInfo');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($qry) use ($search) {
            return $qry->where('title', 'LIKE', '%' . $search . '%');
        });
    }
}
