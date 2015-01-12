<?php
namespace SugarClient\Helper;

use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Functions;
use SugarClient\ParametersBuilder;
use SugarClient\Request;
use SugarClient\Session;

class ModuleFields
{
    private $result;
    private $fields = array();

    private function __construct($result)
    {
        $this->result = $result;
        $this->prepare();
    }

    private function prepare()
    {
        $moduleFields = (array)$this->result->module_fields;
        $this->fields = array_values(Arrays::map($moduleFields, Functions::extract()->name));
    }

    public function all()
    {
        return $this->fields;
    }

    public static function forModule($moduleName)
    {
        $moduleName = ucfirst($moduleName);
        $parametersBuilder = new ParametersBuilder();
        $parameters = $parametersBuilder
            ->addEntry('session', Session::$sessionId)
            ->addEntry('module_name', $moduleName)
            ->addEntry('fields', array())
            ->toArray();
        return new self(Request::callMethod('get_module_fields', $parameters));
    }
}
