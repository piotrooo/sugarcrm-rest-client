<?php
namespace SugarClient\Relation;

use Exception;
use Ouzo\Utilities\Arrays;

/**
 * Class Relations
 * @package SugarClient\Relation
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class Relations
{
    private static $relationNames = array('hasOne', 'belongsTo', 'hasMany');

    private $params;
    private $relations;

    public function __construct(array $params)
    {
        $this->params = $params;
        $this->addRelations();
    }

    private function addRelations()
    {
        foreach (self::$relationNames as $relationName) {
            if (isset($this->params[$relationName])) {
                foreach ($this->params[$relationName] as $name => $type) {
                    $this->addRelation($name, $type);
                }
            }
        }
    }

    private function addRelation($name, $type)
    {
        $this->relations[$name] = $type;
    }

    public function getRelation($name)
    {
        $value = Arrays::getValue($this->relations, $name);
        if (is_null($value)) {
            throw new Exception("Relation not found");
        }
        return $value;
    }

    public function hasRelation($name)
    {
        return isset($this->relations[$name]);
    }

    public static function fromArray(array $params)
    {
        return new self($params);
    }
}
