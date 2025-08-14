<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Country extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['alias','status','currency_status'];

    protected function currency():Attribute{
        return Attribute::make(
            set:fn($value)=>Str::squish($value),
            get:fn($value)=>strtoupper(Str::squish($value))
        );
    }


    function states(){
        return $this->hasMany(State::class);
    }
    function scopeActive($query){
        return $query->where('status',1);
    }
    function scopeDeactive($query){
        return $query->where('status',0);
    }
    function scopeActiveCurrency($query){
        return $query->where('currency_status',1);
    }
}
