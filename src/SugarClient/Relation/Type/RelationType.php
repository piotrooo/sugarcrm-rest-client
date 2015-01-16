<?php
namespace SugarClient\Relation\Type;

use Ouzo\Utilities\Inflector;

/**
 * Class RelationType
 * @package SugarClient\Relation\Type
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
abstract class RelationType
{
    protected $module;

    abstract public function isCollection();

    public function getModuleName()
    {
        return ucfirst($this->module);
    }

    public function getDbName()
    {
        return strtolower($this->module);
    }

    public static function module($module)
    {
        $module = Inflector::pluralize($module);
        return new static($module);
    }
}
