<?php
namespace SugarClient\Http\ApiAction;

use Ouzo\Utilities\Json;

class Login implements RequestAction
{
    private $login;
    private $password;

    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = md5($password);
    }

    public function getRestData()
    {
        $parameters = array(
            'user_auth' => array(
                'user_name' => $this->login,
                'password' => $this->password,
                'version' => 1
            ),
            'application_name' => 'RestTest',
            'name_value_list' => array()
        );
        return Json::encode($parameters);
    }

    public function getMethod()
    {
        return 'login';
    }
}
