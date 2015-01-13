<?php
namespace SugarClient\Relation\Type;

use SugarClient\Module;

class BelongsTo extends RelationType
{
    private function __construct(Module $module)
    {
        $this->module = $module;
    }

    public static function module($module)
    {
        $module = new $module();
        return new self($module);
    }

    public function isCollection()
    {
        return false;
    }
}
