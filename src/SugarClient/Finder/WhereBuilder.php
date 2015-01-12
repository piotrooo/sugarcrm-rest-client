<?php
namespace SugarClient\Finder;

class WhereBuilder extends BaseBuilder
{
    private static $reservedKeywordsRegExp = '/LIKE|IN/i';

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
        } elseif (is_string($params)) {
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
        return preg_match(self::$reservedKeywordsRegExp, $string);
    }

    private function getAlias()
    {
        return strtolower($this->module);
    }
}
