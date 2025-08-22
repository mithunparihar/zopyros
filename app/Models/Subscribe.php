<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Subscribe extends Model
{
    use HasFactory, SoftDeletes;

    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
        );
    }
}
