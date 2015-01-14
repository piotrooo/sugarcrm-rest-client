<?php
namespace SugarClient\Finder;

use SugarClient\Http\Request;
use SugarClient\Http\Requests;

class BaseBuilder
{
    protected $module;
    protected $moduleObject;
    protected $where = '';

    public function whereAsString()
    {
        return $this->where;
    }

    public function fetch()
    {
        $results = Request::call(Requests::getEntryList($this->module, $this->where));
        return SearchHelper::convertRowToModule($results->entry_list[0], $this->moduleObject);
    }

    public function fetchAll()
    {
        $results = Request::call(Requests::getEntryList($this->module, $this->where));
        return SearchHelper::convertResultToModules($results, $this->moduleObject);
    }
}
