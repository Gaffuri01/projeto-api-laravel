<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public static function onlyNumbers($str)
    {
        preg_match_all('!\d+!', $str, $matches);
        return self::removeSpaces(implode('', $matches[0]));
    }

    public static function removeSpaces($n)
    {
        return preg_replace('/\s+/', '', $n);
    }
}
