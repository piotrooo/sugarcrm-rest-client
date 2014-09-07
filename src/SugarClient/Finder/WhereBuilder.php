<?php
namespace SugarClient\Finder;

use SugarClient\ParametersBuilder;
use SugarClient\Request;
use SugarClient\Session;

class WhereBuilder
{
    private static $reservedKeywords = '/LIKE|IN/i';

    private $module;
    private $moduleObject;
    private $where = '';

    public function __construct($module, $moduleObject, $params)
    {
        $this->module = $module;
        $this->moduleObject = $moduleObject;
        $this->where = $this->prepareWhere($params);
    }

    private function prepareWhere($params)
    {
        $whereString = '';
        if (is_array($params)) {
            foreach ($params as $column => $value) {
                $whereString .= $this->buildWhereForSingleValue($column, $value);
            }
            $whereString = rtrim($whereString, ' AND ');
        } else if (is_string($params)) {
            $whereString = $params;
        }
        return $whereString;
    }

    private function buildWhereForSingleValue($column, $value)
    {
        $where = $this->getAlias() . '.' . $column;
        if ($this->isValueHasReservedKeywords($value)) {
            $where .= ' ' . $value . ' AND ';
        } else {
            $where .= " = '" . $value . "' AND ";
        }
        return $where;
    }

    private function isValueHasReservedKeywords($string)
    {
        return preg_match(self::$reservedKeywords, $string);
    }

    private function getAlias()
    {
        return strtolower($this->module);
    }

    public function whereAsString()
    {
        return $this->where;
    }

    public function __toString()
    {
        return $this->whereAsString();
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