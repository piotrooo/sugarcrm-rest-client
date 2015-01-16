<?php
namespace SugarClient\Core;

use BadMethodCallException;
use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Inflector;
use ReflectionClass;
use SugarClient\Helper\DynamicFinder;
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

    public function __get($name)
    {
        $value = Arrays::getValue($this->attributes, $name);
        if ($value) {
            return $value;
        }
        if ($this->relations->hasRelation($name)) {
            $this->fetchRelation($name);
            return $this->attributes[$name];
        }
        return null;
    }

    private function fetchRelation($name)
    {
        $relation = $this->relations->getRelation($name);
        $relationFetcher = RelationFetcher::getRelation($this, $relation);
        $result = $relationFetcher->fetchRelation();
        $this->attributes[$name] = $result;
    }

    public function __isset($name)
    {
        return $this->__get($name) !== null;
    }

    public function getModuleDbName()
    {
        return strtolower($this->getModuleName());
    }

    public static function __callStatic($name, $arguments)
    {
        Session::checkSession();
        $dynamicFinder = DynamicFinder::match($name);
        if ($dynamicFinder) {
            $where = Arrays::combine($dynamicFinder->getNames(), $arguments);
            return static::where($where);
        }
        throw new BadMethodCallException('Method [' . $name . '] not exists');
    }

    public static function where($params)
    {
        return static::queryBuilder()->where($params);
    }

    public static function queryBuilder()
    {
        return new ModuleQueryBuilder(static::newInstance());
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
