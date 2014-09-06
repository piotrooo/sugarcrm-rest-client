<?php
namespace SugarClient\Finder;

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
}