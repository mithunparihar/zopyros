<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Variant extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = ['is_publish'];

    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
        );
    }

    public function categories()
    {
        return $this->hasMany(CategoryVariant::class,'variant_id','id');
    }

    public function scopeActive($query)
    {
        return $query->whereIsPublish(1);
    }
}
