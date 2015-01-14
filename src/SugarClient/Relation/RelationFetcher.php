<?php
namespace SugarClient\Relation;

use SugarClient\Finder\SearchHelper;
use SugarClient\Helper\ClassCreator;
use SugarClient\Helper\ModuleFields;
use SugarClient\Http\Request;
use SugarClient\Http\Requests;
use SugarClient\Module;
use SugarClient\ParametersBuilder;
use SugarClient\Relation\Type\RelationType;
use SugarClient\Session;

class RelationFetcher
{
    /**
     * @var Module
     */
    private $module;
    /**
     * @var Module
     */
    private $relationModule;
    /**
     * @var RelationType
     */
    private $relation;

    public function __construct(Module $module, RelationType $relation)
    {
        $this->module = $module;
        $this->relationModule = ClassCreator::createModule($relation->getModuleName());
        $this->relation = $relation;
    }

    public function fetchRelation()
    {
        $requestAction = Requests::getRelationships($this->module->getModuleName(), $this->module->id, $this->relation->getDbName(), $this->relation->getModuleName());
        $results = Request::call($requestAction);
        if ($this->relation->isCollection()) {
            return SearchHelper::convertResultToModules($results, $this->relationModule);
        }
        return SearchHelper::convertRowToModule($results->entry_list[0], $this->relationModule);
    }

    public static function getRelation(Module $module, RelationType $relation)
    {
        $parametersBuilder = new ParametersBuilder();
        $parameters = $parametersBuilder
            ->addEntry('session', Session::$sessionId)
            ->addEntry('module_name', $module->getModuleName())
            ->addEntry('module_id', $module->id)
            ->addEntry('link_field_name', $relation->getDbName())
            ->addEntry('related_module_query', 0)
            ->addEntry('related_fields', ModuleFields::forModule($relation->getModuleName())->all())
            ->addEntry('related_module_link_name_to_fields_array', array())
            ->addEntry('deleted', 0)
            ->toArray();
        return new self($module, $relation);
    }
}
