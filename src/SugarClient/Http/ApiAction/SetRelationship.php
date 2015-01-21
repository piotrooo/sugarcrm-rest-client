<?php
namespace SugarClient\Http\ApiAction;

use Ouzo\Utilities\Json;
use SugarClient\Core\Session;

/**
 * Class SetRelationship
 * @package SugarClient\Http\ApiAction
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class SetRelationship implements RequestAction
{
    private $moduleName;
    private $moduleId;
    private $relationModuleDbName;
    private $relationModuleId;

    public function __construct($moduleName, $moduleId, $relationModuleDbName, $relationModuleId)
    {
        $this->moduleName = $moduleName;
        $this->moduleId = $moduleId;
        $this->relationModuleDbName = $relationModuleDbName;
        $this->relationModuleId = $relationModuleId;
    }

    public function getRestData()
    {
        $parameters = array(
            'session' => Session::$sessionId,
            'module_name' => $this->moduleName,
            'module_id' => $this->moduleId,
            'link_field_name' => $this->relationModuleDbName,
            'related_ids' => array($this->relationModuleId),
            'name_value_list' => array(),
            'delete' => 0
        );
        return Json::encode($parameters);
    }

    public function getMethod()
    {
        return 'set_relationship';
    }
}
