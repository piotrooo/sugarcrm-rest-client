<?php
namespace SugarClient\Helper;

use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Functions;
use SugarClient\Http\Request;
use SugarClient\Http\Requests;

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
        return new self(Request::call(Requests::getModuleFields($moduleName)));
    }
}
