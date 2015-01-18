<?php
namespace SugarClient\Helper;

use SugarClient\Http\Request;
use SugarClient\Http\Requests;

class CurrentUser
{
    public static function getId()
    {
        return Request::call(Requests::getUserId());
    }
}
