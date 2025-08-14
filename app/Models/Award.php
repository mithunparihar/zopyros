<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Award extends Model
{
    use HasFactory, SoftDeletes;

   
    public $fillable = ['is_publish'];

    public function scopeActive($query)
    {
        return $query->whereIsPublish(1);
    }
}
