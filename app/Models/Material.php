<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Material extends Model
{
    use HasFactory,SoftDeletes;
    public $fillable =['is_publish','is_home'];

    protected function title():Attribute{
        return Attribute::make(
            set:fn($value)=>Str::squish($value),
        );
    }
    protected function alias():Attribute{
        return Attribute::make(
            set:fn($value)=>strtolower(Str::slug($value)),
            get:fn($value)=>strtolower(Str::slug($value))
        );
    }
    public function scopeActive($query){
        return $query->whereIsPublish(1)->orderBy('sequence');
    }

    public function scopeFooter($query)
    {
        return $query->whereIsHome(1);
    }
}
