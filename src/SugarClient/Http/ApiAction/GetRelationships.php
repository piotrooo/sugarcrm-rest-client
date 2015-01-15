<?php
namespace SugarClient\Http\ApiAction;

use Ouzo\Utilities\Json;
use SugarClient\Core\Session;
use SugarClient\Helper\ModuleFields;
use SugarClient\Module;

class GetRelationships implements RequestAction
{
    private $moduleName;
    private $moduleId;
    private $relationModuleDbName;
    private $relationModuleName;

    public function __construct($moduleName, $moduleId, $relationModuleDbName, $relationModuleName)
    {
        $this->moduleName = $moduleName;
        $this->moduleId = $moduleId;
        $this->relationModuleDbName = $relationModuleDbName;
        $this->relationModuleName = $relationModuleName;
    }

    public function getRestData()
    {
        $parameters = array(
            'session' => Session::$sessionId,
            'module_name' => $this->moduleName,
            'module_id' => $this->moduleId,
            'link_field_name' => $this->relationModuleDbName,
            'related_module_query' => 0,
            'related_fields' => ModuleFields::forModule($this->relationModuleName)->all(),
            'related_module_link_name_to_fields_array' => array(),
            'deleted' => 0
        );
        return Json::encode($parameters);
    }

    public function getMethod()
    {
        return 'get_relationships';
    }
}
