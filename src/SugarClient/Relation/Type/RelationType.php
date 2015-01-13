<?php
namespace SugarClient\Relation\Type;

use SugarClient\Module;

abstract class RelationType
{
    /**
     * @var Module
     */
    protected $module;

    public function getModuleName()
    {
        return ucfirst($this->getDbName());
    }

    public function getDbName()
    {
        return strtolower($this->module->getModuleName());
    }

    abstract public function isCollection();
}
