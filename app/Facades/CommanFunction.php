<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CommanFunction extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'commanfunction';
    }
}
