<?php
namespace SugarClient\Relation\Type;

/**
 * Class BelongsTo
 * @package SugarClient\Relation\Type
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class BelongsTo extends RelationType
{
    public function __construct($module)
    {
        $this->module = $module;
    }

    public function isCollection()
    {
        return false;
    }
}
