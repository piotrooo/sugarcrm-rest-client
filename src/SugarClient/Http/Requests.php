<?php
namespace SugarClient\Http;

use SugarClient\Http\ApiAction\GetEntryList;
use SugarClient\Http\ApiAction\GetModuleFields;
use SugarClient\Http\ApiAction\GetRelationships;
use SugarClient\Http\ApiAction\Login;

class Requests
{
    public static function login($login, $password)
    {
        return new Login($login, $password);
    }

    public static function getModuleFields($moduleName, array $fields = array())
    {
        return new GetModuleFields($moduleName, $fields);
    }

    public static function getEntryList($moduleName, $where)
    {
        return new GetEntryList($moduleName, $where);
    }

    public static function getRelationships($moduleName, $moduleId, $relationModuleDbName, $relationModuleName)
    {
        return new GetRelationships($moduleName, $moduleId, $relationModuleDbName, $relationModuleName);
    }
}
