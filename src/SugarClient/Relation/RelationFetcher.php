<?php
namespace SugarClient\Relation;

use SugarClient\Finder\SearchHelper;
use SugarClient\Helper\ClassCreator;
use SugarClient\Helper\ModuleFields;
use SugarClient\Http\Request;
use SugarClient\Module;
use SugarClient\ParametersBuilder;
use SugarClient\Relation\Type\RelationType;
use SugarClient\Session;

class RelationFetcher
{
    /**
     * @var RelationType
     */
    private $relation;
    /**
     * @var Module
     */
    private $module;
    private $parameters;

    public function __construct(RelationType $relation, $parameters)
    {
        $this->module = ClassCreator::createModule($relation->getModuleName());
        $this->relation = $relation;
        $this->parameters = $parameters;
    }

    public function fetchRelation()
    {
        $results = Request::callMethod('get_relationships', $this->parameters);
        if ($this->relation->isCollection()) {
            return SearchHelper::convertResultToModules($results, $this->module);
        }
        return SearchHelper::convertRowToModule($results->entry_list[0], $this->module);
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
        return new self($relation, $parameters);
    }
}
