<?php
namespace SugarClient\Core;

use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Functions;
use Ouzo\Utilities\Joiner;
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

    public function fetch()
    {
        Session::checkSession();
        $results = $this->doRequest();
        $module = Converter::toModule($results->entry_list[0], $this->module);
        foreach ($this->joinClauses as $join) {
            $module->fetchRelation($join->getRelationName(), $join->getRelationFields());
        }
        return $module;
    }

    public function fetchAll()
    {
        Session::checkSession();
        $results = $this->doRequest();
        $modules = Converter::toModules($results, $this->module);
        foreach ($this->joinClauses as $join) {
            $modules = Arrays::map($modules, function (Module $module) use ($join) {
                $module->fetchRelation($join->getRelationName(), $join->getRelationFields());
                return $module;
            });
        }
        return $modules;
    }

    private function doRequest()
    {
        return Request::call(Requests::getEntryList($this->module->getModuleName(), $this->prepareWhere(), $this->fields));
    }

    private function prepareWhere()
    {
        return Joiner::on(' ')
            ->mapValues(Functions::extract()->getWhere())
            ->join($this->whereClauses);
    }
}
