<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Banner extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = ['is_publish'];
    protected $casts = [
        'heading' => 'array',
    ];

    protected function short_description(): Attribute
    {
        return Attribute::make(
            set: fn($value) => \Content::purifierClean(Str::squish($value)),
        );
    }

    public function scopeActive($query)
    {
        return $query->whereIsPublish(1);
    }

    public function scopeSection($query, $section)
    {
        return $query->whereSection($section);
    }
}
