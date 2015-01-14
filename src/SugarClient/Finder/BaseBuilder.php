<?php
namespace SugarClient\Finder;

use SugarClient\Http\Request;
use SugarClient\Http\Requests;

class BaseBuilder
{
    protected $module;
    protected $moduleObject;
    protected $where = '';

    private $fields = array();

    public function whereAsString()
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
        $results = Request::call(Requests::getEntryList($this->module, $this->where, $this->fields));
        return SearchHelper::convertRowToModule($results->entry_list[0], $this->moduleObject);
    }

    public function fetchAll()
    {
        $results = Request::call(Requests::getEntryList($this->module, $this->where, $this->fields));
        return SearchHelper::convertResultToModules($results, $this->moduleObject);
    }
}
