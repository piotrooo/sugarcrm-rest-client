<?php
namespace SugarClient\Core;

use BadMethodCallException;
use Exception;
use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Inflector;
use ReflectionClass;
use SugarClient\Helper\DynamicFinder;
use SugarClient\Http\Request;
use SugarClient\Http\Requests;
use SugarClient\Relation\RelationFetcher;
use SugarClient\Relation\Relations;

/**
 * Class Module
 * @package SugarClient\Core
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
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

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function fetchRelation($name, array $fields = array())
    {
        $relation = $this->relations->getRelation($name);
        if (!$this->isRelationIsStored($name)) {
            $relationFetcher = RelationFetcher::getRelation($this, $relation);
            $result = $relationFetcher->fetchRelation($fields);
            $this->attributes[$name] = $result;
        }
    }

    private function isRelationIsStored($name)
    {
        return isset($this->attributes[$name]);
    }

    public function __isset($name)
    {
        return $this->__get($name) !== null;
    }

    public function getAttributes()
    {
        return $this->attributes;
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

    public static function queryBuilder()
    {
        return new ModuleQueryBuilder(static::newInstance());
    }

    /**
     * @param $params
     * @return ModuleQueryBuilder
     */
    public static function where($params = array())
    {
        return static::queryBuilder()->where($params);
    }

    /**
     * @param $relationName
     * @param array $relationFields
     * @return ModuleQueryBuilder
     */
    public static function join($relationName, array $relationFields = array())
    {
        return static::queryBuilder()->join($relationName, $relationFields);
    }

    public static function count($where = array())
    {
        return static::queryBuilder()->where($where)->count();
    }

    public static function findById($id, array $fields = array())
    {
        return static::queryBuilder()
            ->where(array('id' => $id))
            ->select($fields)
            ->fetch();
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

    public function insert()
    {
        $id = Query::insert($this->attributes)->into($this->getModuleName());
        $this->id = $id;
        return $id;
    }

    public function update()
    {
        Query::update($this->attributes)->whereId($this->id)->into($this->getModuleName());
    }

    public function delete()
    {
        return (bool)static::queryBuilder()
            ->where(array('id' => $this->id, 'deleted' => 1))
            ->delete();
    }

    public function relatedWith(Module $module)
    {
        $result = Request::call(Requests::setRelationship($this->getModuleName(), $this->id, $module->getModuleDbName(), $module->id));
        if ($result->failed) {
            throw new Exception("Creating relationship failed");
        }
        return $result->created == 1;
    }

    public function reload()
    {
        $this->attributes = $this->findById($this->id)->attributes;
        return $this;
    }
}
