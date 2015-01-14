<?php
namespace SugarClient\Relation\Type;

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
