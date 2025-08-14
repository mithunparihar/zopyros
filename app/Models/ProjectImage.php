<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProjectImage extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = ['is_primary'];

    protected function image(): Attribute
    {
        return Attribute::make(
            set:fn($value)=>strtolower(Str::replace(' ','-',Str::squish($value))),
            // get:fn($value)=>ucwords(Str::squish($value))
        );
    }


    function galleryInfo(){
        return $this->hasOne(Project::class,'id','project_id');
    }

    public function scopeActive($query)
    {
        return $query->whereIsPublish(1);
    }

    public function scopePrimary($query){
        return $query->whereIsPrimary(1);
    }

    public function scopeGallery($query, $inspiration)
    {
        return $query->whereProjectId($inspiration);
    }
}
