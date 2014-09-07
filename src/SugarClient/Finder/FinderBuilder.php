<?php
namespace SugarClient\Finder;

use SugarClient\Module;
use SugarClient\ParametersBuilder;
use SugarClient\Request;
use SugarClient\Session;

class FinderBuilder
{
    private $module;
    private $moduleObject;
    private $where = '';

    public function __construct($module, $moduleObject, $where)
    {
        $this->module = $module;
        $this->moduleObject = $moduleObject;
        $this->where = $this->prepareWhere($where);
    }

    private function prepareWhere($where)
    {
        if (is_array($where)) {
            $whereString = '';
            foreach ($where as $column => $value) {
                $whereString .= strtolower($this->module) . '.' . $column . " = '" . $value . "' AND ";
            }
            return rtrim($whereString, ' AND ');
        }
        return '';
    }

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