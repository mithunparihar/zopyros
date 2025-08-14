<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cms extends Model
{
    use HasFactory;
    public $fillable = ['is_publish'];
    protected $casts=[
        'counters' => 'array'
    ];
    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
            // get:fn($value)=>ucwords(Str::squish($value))
        );
    }
    protected function heading(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
            // get:fn($value)=>ucwords(Str::squish($value))
        );
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            set: fn($value) => \Content::purifierClean(Str::squish($value)),
        );
    }
    protected function shortDescription(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
        );
    }
}
