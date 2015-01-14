<?php
namespace SugarClient\Relation\Type;

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
