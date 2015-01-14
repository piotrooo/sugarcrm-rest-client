<?php
namespace SugarClient;

use Exception;
use SugarClient\Http\Request;
use SugarClient\Http\Requests;

class Session
{
    public static $url;
    public static $sessionId = null;

    public static function connect($url, $login, $password)
    {
        self::$url = $url;
        $result = Request::call(Requests::login($login, $password));
        if (isset($result->number) && $result->number == 10) {
            throw new LoginException($result->name);
        }
        self::$sessionId = $result->id;
        return true;
    }

    public static function checkSession()
    {
        if (is_null(self::$sessionId)) {
            throw new Exception('Session is not established. Please authorize to SugarCRM.');
        }
    }
}
