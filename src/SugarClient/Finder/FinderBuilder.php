<?php
namespace SugarClient\Finder;

use SugarClient\ParametersBuilder;
use SugarClient\Request;
use SugarClient\Session;

class FinderBuilder
{
    private $module;
    private $where;

    public function __construct($module, $where)
    {
        $this->module = $module;
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
        return Request::callMethod('get_entry_list', $parameters);
    }
}