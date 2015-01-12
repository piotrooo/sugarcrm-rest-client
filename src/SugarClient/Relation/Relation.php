<?php
namespace SugarClient\Relation;

use SugarClient\Finder\SearchHelper;
use SugarClient\Helper\ClassCreator;
use SugarClient\Helper\ModuleFields;
use SugarClient\Module;
use SugarClient\ParametersBuilder;
use SugarClient\Request;
use SugarClient\Session;

class Relation
{
    /**
     * @var Module
     */
    private $module;
    private $parameters;

    public function __construct($module, $parameters)
    {
        $this->module = ClassCreator::createModule($module);
        $this->parameters = $parameters;
    }

    public function fetchRelation()
    {
        $results = Request::callMethod('get_relationships', $this->parameters);
        return SearchHelper::convertResultToModules($results, $this->module);
    }

    public static function getRelation(Module $module, $relationName)
    {
        $parametersBuilder = new ParametersBuilder();
        $parameters = $parametersBuilder
            ->addEntry('session', Session::$sessionId)
            ->addEntry('module_name', $module->getModuleName())
            ->addEntry('module_id', $module->id)
            ->addEntry('link_field_name', $relationName)
            ->addEntry('related_module_query', 0)
            ->addEntry('related_fields', ModuleFields::forModule($relationName)->all())
            ->addEntry('related_module_link_name_to_fields_array', array())
            ->addEntry('deleted', 0)
            ->toArray();
        return new self($relationName, $parameters);
    }
}