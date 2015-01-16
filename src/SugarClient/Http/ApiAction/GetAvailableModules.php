<?php
namespace SugarClient\Http\ApiAction;

use Ouzo\Utilities\Json;
use SugarClient\Core\Session;

class GetAvailableModules implements RequestAction
{
    public function getRestData()
    {
        $parameters = array(
            'session' => Session::$sessionId,
            'filter' => 'all'
        );
        return Json::encode($parameters);
    }

    public function getMethod()
    {
        return 'get_available_modules';
    }
}
