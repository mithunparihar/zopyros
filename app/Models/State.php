<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Laravel\Scout\Searchable;
// use MongoDB\Laravel\Eloquent\Model;
// use MongoDB\Laravel\Eloquent\SoftDeletes;

class State extends Model
{
    use HasFactory,SoftDeletes;
    // use Searchable;
    

    protected $fillable = ['alias','status'];
    function cities(){
        return $this->hasMany(City::class);
    }
    function countryinfo(){
        return $this->hasOne(Country::class,'id','country_id');
    }
    function posting(){
        return $this->hasMany(House::class,'state_id','id');
    }

    function scopeCountry($query,$countryId){
        return $query->where('country_id',(int)$countryId);
    }
    function scopeActive($query){
        return $query->where(['status'=>1]);
    }
    function scopeDeactive($query){
        return $query->where(['status'=>0]);
    }
}
