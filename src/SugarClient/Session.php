<?php
namespace SugarClient;

class Session
{
    public static $url;
    public static $sessionId = null;

    public static function connect($url, $login, $password)
    {
        self::$url = $url;
        $parameters = array(
            'user_auth' => array(
                'user_name' => $login,
                'password' => md5($password),
                'version' => 1
            ),
            'application_name' => 'RestTest',
            'name_value_list' => array()
        );

        $result = Request::callMethod('login', $parameters);
        if (isset($result->number) && $result->number == 10) {
            throw new LoginException($result->name);
        }
        self::$sessionId = $result->id;
        return true;
    }
}