<?php
namespace SugarClient\Http;

use SugarClient\Http\ApiAction\RequestAction;

/**
 * Class Request
 * @package SugarClient\Http
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class Request
{
    public static $requestHandler = null;

    public static function call(RequestAction $requestAction)
    {
        $post = array(
            "method" => $requestAction->getMethod(),
            "input_type" => "JSON",
            "response_type" => "JSON",
            "rest_data" => $requestAction->getRestData()
        );
        return self::doRequest($post);
    }

    public static function callMethod($method, $parameters)
    {
        $post = array(
            "method" => $method,
            "input_type" => "JSON",
            "response_type" => "JSON",
            "rest_data" => json_encode($parameters)
        );
        return self::doRequest($post);
    }

    private static function doRequest($post)
    {
        return self::$requestHandler->handle($post);
    }
}

Request::$requestHandler = new RequestHandler();
