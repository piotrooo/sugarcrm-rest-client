<?php
namespace SugarClient\Http;

use SugarClient\Http\ApiAction\GetAvailableModules;
use SugarClient\Http\ApiAction\GetDocumentRevision;
use SugarClient\Http\ApiAction\GetEntriesCount;
use SugarClient\Http\ApiAction\GetEntry;
use SugarClient\Http\ApiAction\GetEntryList;
use SugarClient\Http\ApiAction\GetModuleFields;
use SugarClient\Http\ApiAction\GetRelationships;
use SugarClient\Http\ApiAction\GetUserId;
use SugarClient\Http\ApiAction\Login;
use SugarClient\Http\ApiAction\SetDocumentRevision;
use SugarClient\Http\ApiAction\SetEntry;
use SugarClient\Http\ApiAction\SetRelationship;

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

    public static function setEntry($moduleName, array $fields = array())
    {
        return new SetEntry($moduleName, $fields);
    }

    public static function setRelationship($moduleName, $moduleId, $relationModuleDbName, $relationModuleId)
    {
        return new SetRelationship($moduleName, $moduleId, $relationModuleDbName, $relationModuleId);
    }

    public static function setDocumentRevision($documentId, $content, $fileName)
    {
        return new SetDocumentRevision($documentId, $content, $fileName);
    }

    public static function getDocumentRevision($documentId)
    {
        return new GetDocumentRevision($documentId);
    }
}
