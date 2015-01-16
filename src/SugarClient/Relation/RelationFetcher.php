<?php
namespace SugarClient\Relation;

use SugarClient\Core\Module;
use SugarClient\Helper\ClassCreator;
use SugarClient\Helper\Converter;
use SugarClient\Http\Request;
use SugarClient\Http\Requests;
use SugarClient\Relation\Type\RelationType;

/**
 * Class RelationFetcher
 * @package SugarClient\Relation
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
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

    public function fetchRelation(array $fields = array())
    {
        $requestAction = Requests::getRelationships($this->module->getModuleName(), $this->module->id, $this->relation->getDbName(), $this->relation->getModuleName(), $fields);
        $results = Request::call($requestAction);
        if ($this->relation->isCollection()) {
            return Converter::toModules($results, $this->relationModule);
        }
        return Converter::toModule($results->entry_list[0], $this->relationModule);
    }

    public static function getRelation(Module $module, RelationType $relation)
    {
        return new self($module, $relation);
    }
}
