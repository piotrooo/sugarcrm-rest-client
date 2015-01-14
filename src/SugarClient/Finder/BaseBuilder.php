<?php
namespace SugarClient\Finder;

use SugarClient\ParametersBuilder;
use SugarClient\Request;
use SugarClient\Session;

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
        $parametersBuilder = new ParametersBuilder();
        $parameters = $parametersBuilder
            ->addEntry('session', Session::$sessionId)
            ->addEntry('module_name', $this->module)
            ->addEntry('query', $this->where)
            ->addEntry('order_by', '')
            ->addEntry('offset', 0)
            ->addEntry('select_fields', '')
            ->addEntry('link_name_to_fields_array', '')
            ->addEntry('max_result', 1)
            ->addEntry('deleted', 0)
            ->addEntry('favorites', false)
            ->toArray();
        $results = Request::callMethod('get_entry_list', $parameters);
        return SearchHelper::convertRowToModule($results->entry_list[0], $this->moduleObject);
    }

    public function fetchAll()
    {
        $parametersBuilder = new ParametersBuilder();
        $parameters = $parametersBuilder
            ->addEntry('session', Session::$sessionId)
            ->addEntry('module_name', $this->module)
            ->addEntry('query', $this->where)
            ->addEntry('order_by', '')
            ->addEntry('offset', 0)
            ->addEntry('select_fields', '')
            ->addEntry('link_name_to_fields_array', '')
            ->addEntry('max_result', 100)
            ->addEntry('deleted', 0)
            ->addEntry('favorites', false)
            ->toArray();
        $results = Request::callMethod('get_entry_list', $parameters);
        return SearchHelper::convertResultToModules($results, $this->moduleObject);
    }
}
