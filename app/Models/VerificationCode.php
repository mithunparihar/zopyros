<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use MongoDB\Laravel\Eloquent\Model;
// use MongoDB\Laravel\Eloquent\SoftDeletes;

class VerificationCode extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['role','otp','expire_at','user_id','attempt'];
    protected $casts = ['expire_at'=>'datetime'];
}
