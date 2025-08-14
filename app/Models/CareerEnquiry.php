<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class CareerEnquiry extends Model
{
    use HasFactory,SoftDeletes;
    public $fillable =['is_publish'];

    protected function name():Attribute{
        return Attribute::make(
            set:fn($value)=>Str::squish($value),
            // get:fn($value)=>ucwords(Str::squish($value))
        );
    }
    protected function education():Attribute{
        return Attribute::make(
            set:fn($value)=>strtolower(Str::squish($value)),
            get:fn($value)=>ucwords(Str::squish($value))
        );
    }
    protected function email():Attribute{
        return Attribute::make(
            set:fn($value)=>strtolower(Str::squish($value)),
            // get:fn($value)=>strtolower(Str::squish($value))
        );
    }

    function countryInfo(){
        return $this->hasOne(Country::class,'phonecode','ccode');
    }
}
