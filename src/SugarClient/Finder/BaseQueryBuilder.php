<?php
namespace SugarClient\Finder;

use SugarClient\Core\Module;
use SugarClient\Helper\Converter;
use SugarClient\Http\Request;
use SugarClient\Http\Requests;

class BaseQueryBuilder
{
    /**
     * @var Module
     */
    protected $module;
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
        $results = Request::call(Requests::getEntryList($this->module->getModuleName(), $this->where, $this->fields));
        return Converter::toModule($results->entry_list[0], $this->module);
    }

    public function fetchAll()
    {
        $results = Request::call(Requests::getEntryList($this->module->getModuleName(), $this->where, $this->fields));
        return Converter::toModules($results, $this->module);
    }
}
