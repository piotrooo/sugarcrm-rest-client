<?php
namespace SugarClient\Core;

use SugarClient\Helper\Converter;
use SugarClient\Http\Request;
use SugarClient\Http\Requests;

class ModuleQueryBuilder
{
    /**
     * @var Module
     */
    private $module;
    private $where = '';
    private $fields = array();

    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    public function where($params)
    {
        $whereBuilder = new WhereBuilder($this->module, $params);
        $this->where = $whereBuilder->getWhere();
        return $this;
    }

    public function getWhere()
    {
        return $this->where;
    }

    public function select()
    {
        $this->fields = func_get_args();
        return $this;
    }

    public function fetch()
    {
        $results = Request::call(Requests::getEntryList($this->module->getModuleName(), $this->where, $this->fields));
        return Converter::toModule($results->entry_list[0], $this->module);
    }

    public function fetchAll()
    {
        $results = Request::call(Requests::getEntryList($this->module->getModuleName(), $this->where, $this->fields));
        return Converter::toModules($results, $this->module);
    }
}