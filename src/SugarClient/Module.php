<?php
namespace SugarClient;

use BadMethodCallException;
use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Inflector;
use ReflectionClass;
use SugarClient\Finder\DynamicFinder;
use SugarClient\Finder\FinderBuilder;
use SugarClient\Finder\WhereBuilder;
use SugarClient\Relation\RelationFetcher;
use SugarClient\Relation\Relations;

abstract class Module
{
    private $attributes = array();
    private $relations;

    public function __construct($params = array())
    {
        $this->attributes = Arrays::getValue($params, 'attributes', array());
        $this->relations = Relations::fromArray($params);
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        $value = Arrays::getValue($this->attributes, $name);
        if ($value) {
            return $value;
        }
        if ($this->relations->hasRelation($name)) {
            $relation = $this->relations->getRelation($name);
            $relationFetcher = RelationFetcher::getRelation($this, $relation);
            $result = $relationFetcher->fetchRelation();
            return $this->attributes[$name] = $result;
        }
        return null;
    }

    public static function __callStatic($name, $arguments)
    {
        Session::checkSession();
        $dynamicFinder = DynamicFinder::match($name);
        if ($dynamicFinder) {
            $where = Arrays::combine($dynamicFinder->getNames(), $arguments);
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
