<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class QuoteEnquiry extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = ['is_publish'];

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
        );
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
        );
    }

    protected function message(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::squish($value),
        );
    }

    public function productInfo()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
