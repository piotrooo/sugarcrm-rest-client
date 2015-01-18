<?php
namespace SugarClient\Http\ApiAction;

use Ouzo\Utilities\Json;
use SugarClient\Core\Session;

/**
 * Class GetUserId
 * @package SugarClient\Http\ApiAction
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class GetUserId implements RequestAction
{
    public function getRestData()
    {
        $parameters = array(
            "session" => Session::$sessionId
        );
        return Json::encode($parameters);
    }

    public function getMethod()
    {
        return 'get_user_id';
    }
}
