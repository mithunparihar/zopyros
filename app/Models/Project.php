<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
// use Laravel\Scout\Searchable;

class Project extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = ['is_publish','is_home'];
    protected $casts=[
        'type_id'=>'array'
    ];

    // public function toSearchableArray()
    // {
    //     return [
    //         'title' => $this->title,
    //     ];
    // }

    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
            // get:fn($value)=>ucwords(Str::squish($value))
        );
    }
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtolower(Str::slug($value)),
            get: fn($value) => strtolower(Str::slug($value))
        );
    }

    public function scopeActive($query)
    {
        return $query->whereIsPublish(1);
    }

    public function scopeHome($query){
        return $query->whereIsHome(1);
    }


    public function images()
    {
        return $this->hasMany(ProjectImage::class, 'project_id', 'id')->orderBY('is_primary', 'DESC');
    }

}
