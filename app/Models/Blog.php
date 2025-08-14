<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = ['is_publish'];

    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
            // get:fn($value)=>ucwords(Str::squish($value))
        );
    }
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtolower(Str::slug($value)),
            get: fn($value) => strtolower(Str::slug($value))
        );
    }

    public function categoryInfo()
    {
        return $this->hasOne(BlogCategory::class, 'id', 'category_id');
    }
    public function tableofcontent()
    {
        return $this->hasMany(BlogTableContent::class, 'blog_id', 'id');
    }
    public function related(){
        return $this->hasMany(Blog::class,'category_id','category_id');
    }

    public function scopeActive($query)
    {
        return $query->whereIsPublish(1);
    }
    public function scopeCategory($query, $category)
    {
        return $query->whereMapId($category);
    }
    public function scopeDeviceLimit($query, $limit)
    {
        $deviceType = \Content::deviceType();
        return $query->take((
            $deviceType['isTablet'] ? (int) ($limit / 1.5) :
            ($deviceType['isMobile'] ? ($limit / 3) :
                $limit)));
    }
}
