<?php
namespace SugarClient\Relation\Type;

/**
 * Class HasMany
 * @package SugarClient\Relation\Type
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class HasMany extends RelationType
{
    public function __construct($module)
    {
        $this->module = $module;
    }

    public function isCollection()
    {
        return true;
    }
}
