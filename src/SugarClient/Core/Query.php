<?php
namespace SugarClient\Core;

use Ouzo\Utilities\Arrays;
use SugarClient\Helper\Converter;
use SugarClient\Http\Request;
use SugarClient\Http\Requests;

/**
 * Class Query
 * @package SugarClient\Core
 * @author Piotr Olaszewski <piotroo89 [%] gmail dot com>
 */
class Query
{
    /**
     * @var Module
     */
    private $module;
    private $fields = array();
    /**
     * @var WhereClause[]
     */
    private $whereClauses = array();
    /**
     * @var JoinClause[]
     */
    private $joinClauses = array();
    private $orderClause = '';

    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    public function select(array $fields = array())
    {
        $this->fields = $fields;
        return $this;
    }

    public function where(WhereClause $whereClause)
    {
        $this->whereClauses[] = $whereClause;
        return $this;
    }

    public function join(JoinClause $joinClause)
    {
        $this->joinClauses[] = $joinClause;
        return $this;
    }

    public function order($orderClause)
    {
        $this->orderClause = $orderClause;
        return $this;
    }

    public function fetch()
    {
        $results = $this->doFetchRequest();
        $module = Converter::toModule($results->entry_list[0], $this->module);
        foreach ($this->joinClauses as $join) {
            $this->addJoin($module, $join);
        }
        return $module;
    }

    public function fetchAll()
    {
        $results = $this->doFetchRequest();
        $modules = Converter::toModules($results, $this->module);
        foreach ($this->joinClauses as $join) {
            $modules = Arrays::map($modules, function (Module $module) use ($join) {
                $module->fetchRelation($join->getRelationName(), $join->getRelationFields());
                return $module;
            });
        }
        return $modules;
    }

    private function doFetchRequest()
    {
        Session::checkSession();
        return Request::call(Requests::getEntryList($this->module->getModuleName(), $this->prepareWhere(), $this->fields, $this->orderClause));
    }

    private function prepareWhere()
    {
        return WherePreparer::prepare($this->whereClauses)->get();
    }

    private function addJoin(Module $module, JoinClause $join)
    {
        $relationNames = explode('->', $join->getRelationName());
        foreach ($relationNames as $name) {
            $module->fetchRelation($name, $join->getRelationFields());
            $module = $module->$name;
        }
    }

    public function count()
    {
        $call = Request::call(Requests::getEntriesCount($this->module->getModuleName(), $this->prepareWhere()));
        return $call->result_count;
    }

    public static function insert($attributes)
    {
        return new QueryInsert($attributes);
    }
}
