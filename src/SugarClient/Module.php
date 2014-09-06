<?php
namespace SugarClient;

use BadMethodCallException;
use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Inflector;
use ReflectionClass;
use SugarClient\Finder\DynamicFinder;
use SugarClient\Finder\FinderBuilder;
use SugarClient\Finder\WhereBuilder;

abstract class Module
{
    private $_attributes = array();

    public function __construct($attributes)
    {
        $this->_attributes = $attributes;
    }

    public function __set($name, $value)
    {
        $this->_attributes[$name] = $value;
    }

    public function __get($name)
    {
        return Arrays::getValue($this->_attributes, $name);
    }

    public static function __callStatic($name, $arguments)
    {
        Session::checkSession();
        $dynamicFinder = DynamicFinder::match($name);
        if ($dynamicFinder) {
            $where = array_combine($dynamicFinder->getNames(), $arguments);
            return static::finderBuilder($where);
        }
        throw new BadMethodCallException('Method [' . $name . '] not exists');
    }

    private static function finderBuilder($where)
    {
        $module = static::getModuleName();
        $moduleObject = static::newInstance();
        return new FinderBuilder($module, $moduleObject, $where);
    }

    public static function where($params)
    {
        return static::whereBuilder($params);
    }

    private static function whereBuilder($params)
    {
        $module = static::getModuleName();
        $moduleObject = static::newInstance();
        return new WhereBuilder($module, $moduleObject, $params);
    }

    public static function getModuleName()
    {
        $reflectionClass = new ReflectionClass(get_called_class());
        return Inflector::pluralize($reflectionClass->getShortName());
    }

    public static function newInstance(array $attributes = array())
    {
        $class = get_called_class();
        return new $class($attributes);
    }
}