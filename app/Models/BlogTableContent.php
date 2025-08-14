<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class BlogTableContent extends Model
{
    use HasFactory,SoftDeletes;
    function blogInfo(){
        return $this->hasOne(Blog::class,'id','blog_id');
    }
}
