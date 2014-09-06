<?php
namespace SugarClient;

use Ouzo\Utilities\Inflector;
use ReflectionClass;
use SugarClient\Finder\DynamicFinder;
use SugarClient\Finder\FinderBuilder;

abstract class Module
{
    public static function __callStatic($name, $arguments)
    {
        Session::checkSession();
        $dynamicFinder = DynamicFinder::match($name);
        if ($dynamicFinder) {
            $where = array_combine($dynamicFinder->getNames(), $arguments);
            return static::finderBuilder($where);
        }
    }

    private static function finderBuilder($where)
    {
        $module = static::getModuleName();
        return new FinderBuilder($module, $where);
    }

    public static function getModuleName()
    {
        $reflectionClass = new ReflectionClass(get_called_class());
        return Inflector::pluralize($reflectionClass->getShortName());
    }
}