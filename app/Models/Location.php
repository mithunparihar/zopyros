<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Location extends Model
{
    use HasFactory,SoftDeletes;
    public $fillable =['is_publish'];

    protected function title():Attribute{
        return Attribute::make(
            set:fn($value)=>Str::squish($value),
            get:fn($value)=>ucwords(Str::squish($value))
        );
    }
    protected function alias():Attribute{
        return Attribute::make(
            set:fn($value)=>strtolower(Str::slug($value)),
            get:fn($value)=>strtolower(Str::slug($value))
        );
    }
    function parentInfo(){
        return $this->hasOne(Location::class,'id','city_id');
    }
    function childs(){
        return $this->hasMany(Location::class,'city_id','id');
    }
    function services(){
        return $this->hasMany(LocationPageContent::class,'city_id','id');
    }

    public function scopeActive($query){
        return $query->whereIsPublish(1);
    }
    public function scopeCity($query,$cityId){
        return $query->whereCityId($cityId);
    }
}
