<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class CategoryFaq extends Model
{
    use HasFactory,SoftDeletes;
    public $fillable =['is_publish'];

    protected function title():Attribute{
        return Attribute::make(
            set:fn($value)=>Str::squish($value),
            // get:fn($value)=>ucwords(Str::squish($value))
        );
    }

    public function scopeCategory($query,$parentId){
        return $query->whereCategoryId($parentId ?? 0);
    }
    public function scopeActive($query){
        return $query->whereIsPublish(1);
    }
}
