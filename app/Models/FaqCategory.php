<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class FaqCategory extends Model
{
    use HasFactory,SoftDeletes;
    public $fillable =['is_publish'];

    protected function title():Attribute{
        return Attribute::make(
            set:fn($value)=>Str::squish($value),
            // get:fn($value)=>ucwords(Str::squish($value))
        );
    }
    protected function description(): Attribute
    {
        return Attribute::make(
            set: fn($value) => \Content::purifierClean(Str::squish($value)),
        );
    }
    protected function alias():Attribute{
        return Attribute::make(
            set:fn($value)=>strtolower(Str::slug($value)),
            get:fn($value)=>strtolower(Str::slug($value))
        );
    }

    function childs(){
        return $this->hasMany(FaqCategory::class,'parent_id','id');
    }

    function parentInfo(){
        return $this->hasOne(FaqCategory::class,'id','parent_id');
    }

    function faqs(){
        return $this->hasMany(Faq::class,'category_id','id');
    }

    public function scopeActive($query){
        return $query->whereIsPublish(1);
    }
    public function scopeParent($query,$parentId){
        return $query->whereParentId($parentId ?? 0);
    }
}
