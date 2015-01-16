<?php
namespace SugarClient\Http\ApiAction;

use Ouzo\Utilities\Json;
use SugarClient\Core\Session;

/**
 * Class GetModuleFields
 * @package SugarClient\Http\ApiAction
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class GetModuleFields implements RequestAction
{
    private $moduleName;
    private $fields;

    public function __construct($moduleName, $fields = array())
    {
        $this->moduleName = $moduleName;
        $this->fields = $fields;
    }

    public function getRestData()
    {
        $parameters = array(
            'session' => Session::$sessionId,
            'module_name' => $this->moduleName,
            'fields' => $this->fields
        );
        return Json::encode($parameters);
    }

    public function getMethod()
    {
        return 'get_module_fields';
    }
}
