<?php
namespace SugarClient\Http\ApiAction;

use Ouzo\Utilities\Json;
use SugarClient\Core\Session;

/**
 * Class SetEntry
 * @package SugarClient\Http\ApiAction
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class SetEntry implements RequestAction
{
    private $moduleName;
    private $fields;

    public function __construct($moduleName, array $fields = array())
    {
        $this->moduleName = $moduleName;
        $this->fields = $fields;
    }

    public function getRestData()
    {
        $parameters = array(
            "session" => Session::$sessionId,
            "module_name" => $this->moduleName,
            "name_value_list" => $this->fields
        );
        return Json::encode($parameters);
    }

    public function getMethod()
    {
        return 'set_entry';
    }
}
