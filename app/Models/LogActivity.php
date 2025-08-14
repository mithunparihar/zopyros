<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogActivity extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['role','url','method','ip','agent','user_id'];

    public function admin(){
        return $this->belongsTo(Admin::class,'user_id');
    }
}
