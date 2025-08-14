<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Faq extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    public $fillable = ['is_publish', 'is_home'];

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'categoryInfo'=>$this->categoryInfo->pluck('title')->toArray()
        ];
    }

    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
            // get:fn($value)=>ucwords(Str::squish($value))
        );
    }
    protected function description(): Attribute
    {
        return Attribute::make(
            set: fn($value) => \Content::purifierClean(Str::squish($value)),
        );
    }
    public function categoryInfo()
    {
        return $this->hasOne(FaqCategory::class, 'id', 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->whereIsPublish(1);
    }
    public function scopeHome($query)
    {
        return $query->whereIsHome(1);
    }
}
