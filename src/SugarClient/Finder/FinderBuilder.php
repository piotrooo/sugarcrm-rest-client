<?php
namespace SugarClient\Finder;

use SugarClient\ParametersBuilder;
use SugarClient\Request;
use SugarClient\Session;

class FinderBuilder
{
    private $module;
    private $moduleObject;
    private $where;

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
        return $this->processResults($results);
    }

    private function processResults($results)
    {
        $modules = array();
        foreach ($results->entry_list as $record) {
            $modules[] = $this->convertRowToModule($record);
        }
        return $modules;
    }

    private function convertRowToModule($row)
    {
        $attributes = array();
        foreach ($row->name_value_list as $data) {
            $name = $data->name;
            $value = $data->value;
            $attributes[$name] = $value;
        }
        return $this->moduleObject->newInstance($attributes);
    }
}