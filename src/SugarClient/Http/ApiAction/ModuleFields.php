<?php
namespace SugarClient\Http\ApiAction;

use Ouzo\Utilities\Json;
use SugarClient\Session;

class ModuleFields implements RequestAction
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
