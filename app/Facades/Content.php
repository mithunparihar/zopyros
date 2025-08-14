<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Content extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'content';
    }
}
