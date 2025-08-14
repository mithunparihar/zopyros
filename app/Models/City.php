<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory,SoftDeletes;
    // use Searchable;
    

    protected $fillable = ['alias','status'];
    function stateInfo(){
        return $this->belongsTo(State::class,'state_id','id');
    }
    function pincodes(){
        return $this->hasMany(Pincode::class,'city_id','id');
    }


    function scopeState($query,$stateId){
        return $query->where('state_id',(int)$stateId);
    }
    function scopeActive($query){
        return $query->where(['status'=>1]);
    }
    function scopeDeactive($query){
        return $query->where(['status'=>0]);
    }
}
