<?php
namespace SugarClient\Http;

use SugarClient\Http\ApiAction\EntryList;
use SugarClient\Http\ApiAction\Login;
use SugarClient\Http\ApiAction\ModuleFields;

class Requests
{
    public static function login($login, $password)
    {
        return new Login($login, $password);
    }

    public static function getModuleFields($moduleName, array $fields = array())
    {
        return new ModuleFields($moduleName, $fields);
    }

    public static function getEntryList($moduleName, $where)
    {
        return new EntryList($moduleName, $where);
    }
}
