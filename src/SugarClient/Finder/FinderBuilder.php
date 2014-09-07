<?php
namespace SugarClient\Finder;

use SugarClient\Module;

class FinderBuilder extends BaseBuilder
{
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
}