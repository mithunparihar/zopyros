<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Meta extends Model
{
    use HasFactory;
    protected function title():Attribute{
        return Attribute::make(
            set:fn($value)=>Str::squish($value),
            get:fn($value)=>Str::squish($value)
        );
    }
    protected function keywords():Attribute{
        return Attribute::make(
            set:fn($value)=>Str::squish($value),
            get:fn($value)=>Str::squish($value)
        );
    }
    protected function description():Attribute{
        return Attribute::make(
            set:fn($value)=>Str::squish($value),
            get:fn($value)=>Str::squish($value)
        );
    }
}
