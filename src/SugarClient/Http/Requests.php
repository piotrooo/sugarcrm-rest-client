<?php
namespace SugarClient\Http;

use SugarClient\Http\ApiAction\GetAvailableModules;
use SugarClient\Http\ApiAction\GetEntriesCount;
use SugarClient\Http\ApiAction\GetEntry;
use SugarClient\Http\ApiAction\GetEntryList;
use SugarClient\Http\ApiAction\GetModuleFields;
use SugarClient\Http\ApiAction\GetRelationships;
use SugarClient\Http\ApiAction\GetUserId;
use SugarClient\Http\ApiAction\Login;

/**
 * Class Requests
 * @package SugarClient\Http
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
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

    public static function getEntryList($moduleName, $where, array $fields = array(), $orderBy = '')
    {
        return new GetEntryList($moduleName, $where, $fields, $orderBy);
    }

    public static function getRelationships($moduleName, $moduleId, $relationModuleDbName, $relationModuleName, array $fields = array())
    {
        return new GetRelationships($moduleName, $moduleId, $relationModuleDbName, $relationModuleName, $fields);
    }

    public static function getAvailableModules()
    {
        return new GetAvailableModules();
    }

    public static function getEntriesCount($moduleName, $where)
    {
        return new GetEntriesCount($moduleName, $where);
    }

    public static function getEntry($moduleName, $id, array $fields = array())
    {
        return new GetEntry($moduleName, $id, $fields);
    }

    public static function getUserId()
    {
        return new GetUserId();
    }
}
