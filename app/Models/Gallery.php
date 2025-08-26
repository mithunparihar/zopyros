<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Gallery extends Model
{
    use HasFactory,SoftDeletes;
    public $fillable =['is_publish'];
    
    public function scopeActive($query){
        return $query->whereIsPublish(1);
    }

    public function scopeType($query,$type){
        return $query->whereType($type);
    }
}
