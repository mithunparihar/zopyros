<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class LocationPageContent extends Model
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

    function location(){
        return $this->hasOne(Location::class,'id','city_id');
    }
    function service(){
        return $this->hasOne(LocationService::class,'id','service_id');
    }

    public function scopeActive($query){
        return $query->whereIsPublish(1);
    }
    public function scopeHome($query){
        return $query->whereIsHome(1);
    }
    public function scopeCity($query,$cityId){
        return $query->whereCityId($cityId);
    }
}
