<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 8/30/2018
 * Time: 12:30 AM
 */
namespace App\Facades;
use Illuminate\Support\Facades\Facade;
class CURL extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CURL';
    }
}
