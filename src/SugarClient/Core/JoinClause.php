<?php
namespace SugarClient\Core;

/**
 * Class JoinClause
 * @package SugarClient\Core
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class JoinClause
{
    private $relationName;
    private $relationFields;

    public function __construct($relationName, array $relationFields = array())
    {
        $this->relationName = $relationName;
        $this->relationFields = $relationFields;
    }

    public function getRelationName()
    {
        return $this->relationName;
    }

    public function getRelationFields()
    {
        return $this->relationFields;
    }
}
