<?php
namespace SugarClient\Core;

use Ouzo\Utilities\Arrays;
use SugarClient\Helper\Converter;
use SugarClient\Http\Request;
use SugarClient\Http\Requests;

/**
 * Class ModuleQueryBuilder
 * @package SugarClient\Core
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class ModuleQueryBuilder
{
    /**
     * @var Module
     */
    private $module;
    private $where = '';
    private $fields = array();
    /**
     * @var JoinClause[]
     */
    private $joined = array();

    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    public function select()
    {
        $this->fields = func_get_args();
        return $this;
    }

    public function where($params)
    {
        $whereBuilder = new WhereClause($this->module, $params);
        $this->where = $whereBuilder->getWhere();
        return $this;
    }

    public function join($relationName, array $relationFields = array())
    {
        $this->joined[] = new JoinClause($relationName, $relationFields);
        return $this;
    }

    public function fetch()
    {
        Session::checkSession();
        $results = Request::call(Requests::getEntryList($this->module->getModuleName(), $this->where, $this->fields));
        $module = Converter::toModule($results->entry_list[0], $this->module);
        foreach ($this->joined as $join) {
            $module->fetchRelation($join->getRelationName(), $join->getRelationFields());
        }
        return $module;
    }

    public function fetchAll()
    {
        Session::checkSession();
        $results = Request::call(Requests::getEntryList($this->module->getModuleName(), $this->where, $this->fields));
        $modules = Converter::toModules($results, $this->module);
        foreach ($this->joined as $join) {
            $modules = Arrays::map($modules, function (Module $module) use ($join) {
                $module->fetchRelation($join->getRelationName(), $join->getRelationFields());
                return $module;
            });
        }
        return $modules;
    }
}
