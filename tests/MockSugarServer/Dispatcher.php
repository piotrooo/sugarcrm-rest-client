<?php
namespace Tests\MockSugarServer;

use Ouzo\Utilities\Json;
use Ouzo\Utilities\Strings;

class Dispatcher
{
    public function handle($data)
    {
        $method = $data['method'];
        $restData = Json::decode($data['rest_data']);

        $class = '\Tests\MockSugarServer\Action\\' . Strings::underscoreToCamelCase($method);
        $action = new $class($restData);
        return $action->process()->response();
    }
}
